<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'rank',
        'point',
        'login_count',
        'access_admin',
        'avatar',
        'gender',
        'birthday',
        'religion_id',
        'location_id',
        'locale_id',
        'invite_code',
        'subscription_new_letter',
        'subscription_reply_noti',
        'locale_id',
        'registered_by',
        'invite_user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar_url',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function confirmPass($value)
    {
        return $this->attributes['password'] == Hash::make($value);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return null; //Do it latter
        }

        return null;
    }

    public static function getByCondition($conditions, $getOne = false)
    {
        $query = self::select('*');

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        if ($getOne) {
            return $query->first();
        }

        return $query->get();
    }
}
