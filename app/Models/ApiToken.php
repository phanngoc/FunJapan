<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $table = 'api_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'expired_to',
    ];

    protected $appends = [
        'is_active'
    ];

    public function getIsActiveAttribute()
    {
        $now = Carbon::now();
        if ($now->lt(Carbon::parse($this->expired_to))) {
            return true;
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
