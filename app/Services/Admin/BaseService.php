<?php

namespace App\Services\Admin;

class BaseService
{
    public static function listItems($query, $keyword, $searchColumns, $order, $limit, $page)
    {
        if ($keyword) {
            $query->where(function ($currentQuery) use ($keyword, $searchColumns) {
                foreach ($searchColumns as $col) {
                    $currentQuery->orWhere($col, 'like', "%$keyword%");
                }
            });
        }

        $query->orderBy($order['column'], $order['dir']);

        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
