<?php
namespace App\Services\Web;

use App\Models\Jmb;

class JmbService
{
    public static function create($inputs)
    {
        return Jmb::create($inputs);
    }

    public static function findByUserId($userId)
    {
        return Jmb::where('user_id', $userId)->get();
    }
}
