<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'locale_id',
    ];

    protected $appends = [
        'email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user',
        'created_unix_time',
        'created_global_date',
        'locale_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEmailAttribute()
    {
        if ($this->user) {
            return $this->user->email;
        }

        return '';
    }

    public function getLastAccessAttribute($value)
    {
        return Carbon::createFromTimestamp($value, config('app.global_timezone'))->toDateTimeString();
    }
}
