<?php
namespace App\Services\Web;

use App\Models\Jmb;

class JmbService
{
    public static function create($inputs)
    {
        $inputs['first_name1'] = $inputs['firstName'];
        $inputs['first_name2'] = $inputs['firstName2'];
        $inputs['first_name3'] = $inputs['firstName3'];
        $inputs['last_name'] = isset($inputs['lastName']) ? $inputs['lastName'] : null;
        $inputs['middle_name'] = isset($inputs['midName']) ? $inputs['midName'] : null;
        $inputs['phone'] = $inputs['phoneNumber'];

        return Jmb::create($inputs);
    }

    public static function findByUserId($userId)
    {
        return Jmb::where('user_id', $userId)->get();
    }
}
