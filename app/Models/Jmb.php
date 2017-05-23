<?php

namespace App\Models;

class Jmb extends BaseModel
{
    protected $table = 'jmb_user_informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name1',
        'first_name2',
        'first_name3',
        'last_name',
        'middle_name',
        'password',
        'city',
        'counttry',
        'zipcode',
        'address1',
        'address2',
        'address3',
        'address4',
        'phone',
    ];
}
