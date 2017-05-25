<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'is_login',
        'session_id',
        'user_ranking',
        'new_user',
        'registered_user',
        'os',
        'ua',
        'user_ip',
        'referral',
        'last_access',
        'created_unix_time',
        'created_global_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
