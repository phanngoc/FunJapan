<?php

namespace App\Services\Admin;

use App\Models\ApiToken;
use App\Models\User;
use DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ApiTokenService extends BaseService
{
    public static function validate($input)
    {
        $validationRules = [
            'expired_to' => 'required|date_format:Y-m-d H:i',
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('access_api', true);
                }),
            ],
        ];

        return Validator::make($input, $validationRules)->messages()->toArray();
    }

    public static function create($input)
    {
        $now = Carbon::now();
        $expriedTo = Carbon::parse($input['expired_to']);
        if ($expriedTo->lt($now)) {
            return false;
        }

        $lifeTime = $expriedTo->diffInMinutes($now);

        $user = User::where('access_api', true)->first();

        config(['jwt.ttl' => $lifeTime]);

        $input['token'] = JWTAuth::fromUser($user);

        $apiToken = ApiToken::create($input);

        return $apiToken;
    }

    public static function getList($conditions)
    {
        $keyword = escape_like($conditions['search']['value']);
        $searchColumns = ['token'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = ApiToken::with('user');

        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page, true);

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function destroy($id)
    {
        $token = ApiToken::find($id);

        try {
            JWTAuth::invalidate($token->token);

            return ApiToken::destroy($id);
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());

            return ApiToken::destroy($id);
        }
    }
}
