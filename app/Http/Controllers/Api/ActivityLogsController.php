<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    public function dauCsv(Request $request)
    {
        $condition = $request->only([
            'date_start',
            'date_end',
        ]);

        $validate = ActivityLogService::validateGetDateForDau($condition);
        if (count($validate)) {
            return response()->json($validate, 400);
        }

        $response = ActivityLogService::getDataForDau($condition);

        return response()->json($response);
    }
}
