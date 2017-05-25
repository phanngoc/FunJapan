<?php

namespace App\Services\Admin;

use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use DB;

class CommentService extends BaseService
{
    public static function list($conditions)
    {
        $keyword = $conditions['search']['value'];
        $searchColumns = ['comments.content', 'users.name'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = Comment::query();
        $query->leftJoin('users', 'comments.user_id', '=', 'users.id');
        if (isset($conditions['locale_id'])) {
            $query->join('article_locales', 'comments.article_locale_id', '=', 'article_locales.id')
            ->where('article_locales.locale_id', $conditions['locale_id'])
            ->select('comments.*', 'users.name');
        }

        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page);
        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function delete($id)
    {
        $comment = Comment::find($id);

        if ($comment) {
            DB::beginTransaction();
            try {
                $comment->favoriteComments()->delete();
                $comment->delete();
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);

                return false;
            }
        }

        return false;
    }
}
