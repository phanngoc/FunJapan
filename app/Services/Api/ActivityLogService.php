<?php

namespace App\Services\Api;

use App\Models\ActivityLog;
use Validator;

class ActivityLogService extends BaseService
{
    public static function validateGetDateForDau($input)
    {
        $rules = [
            'date_start' => 'required|date',
            'date_end' => 'required|date',
        ];

        return Validator::make($input, $rules)->messages()->toArray();
    }

    public static function getDataForDau($condition)
    {
        $result = [];

        $logs = ActivityLog::where('created_global_date', '>=', $condition['date_start'])
            ->where('created_global_date', '<=', $condition['date_end'])
            ->get();

        foreach ($logs as $log) {
            $result[$log->created_global_date][] =  $log;
        }

        return $result;
    }
}
