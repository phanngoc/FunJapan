<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Article;

class BaseService
{
    public static function listItems($query, $keyword, $searchColumns, $order, $limit, $page, $otherCondition = null)
    {
        if ($keyword) {
            $query->where(function ($currentQuery) use ($keyword, $searchColumns, $otherCondition) {
                foreach ($searchColumns as $col) {
                    $currentQuery->orWhere($col, 'like', "%$keyword%");
                }
                if ($otherCondition) {
                    $userIds = User::where('name', 'like', '%' . escape_like($keyword) . '%')
                        ->pluck('id');
                    $articleIds = Article::whereIn('user_id', $userIds)->pluck('id');
                    $currentQuery->orWhereIn('article_id', $articleIds);
                }
            });
        }

        if ($order['column'] == 'user_id') {
            // TO DO
        } else {
            $query->orderBy($order['column'], $order['dir']);
        }

        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
