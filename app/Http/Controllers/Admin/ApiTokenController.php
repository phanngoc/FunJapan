<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\ApiTokenService;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class ApiTokenController extends Controller
{
    public function store(Request $request)
    {
        abort_if(Gate::denies('permission', 'api.add'), 403, 'Unauthorized action.');

        $input = $request->only(['expired_to', 'user_name', 'user_id']);

        $validate = ApiTokenService::validate($input);

        if (count($validate)) {
            return redirect()->back()
                ->withInput($input)
                ->withErrors($validate);
        }

        $token = ApiTokenService::create($input);

        if ($token) {
            return redirect()->back()
                ->with(['message' => trans('admin/api_token.messages.success')]);
        } else {
            return redirect()->back()
                ->withInput($input)
                ->withErrors([trans('admin/api_token.messages.fail')]);
        }
    }

    public function index()
    {
        abort_if(Gate::denies('permission', [['api.add', 'api.list']]), 403, 'Unauthorized action.');

        return view('admin.api_token.show', $this->viewData);
    }

    public function lists(Request $request)
    {
        $params = $request->input();
        $draw = $params['draw'];
        $articlesData = ApiTokenService::getList($params);
        $articlesData['draw'] = (int)$draw;

        return $articlesData;
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('permission', 'api.delete'), 403, 'Unauthorized action.');

        $isDeleted = ApiTokenService::destroy($id);

        if ($isDeleted) {
            return redirect()->back()->with(['message' => trans('admin/api_token.messages.delete_success')]);
        } else {
            return redirect()->back()
                ->withErrors([trans('admin/api_token.messages.delete_fail')]);
        }
    }

    public function getUser(Request $request)
    {
        $condition = $request->only(['key_word', 'page']);

        return response()->json(UserService::getUserForApi($condition));
    }
}
