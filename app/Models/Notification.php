<?php

namespace App\Models;

class Notification extends BaseModel
{
    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'user_id',
        'sender_id',
        'type',
        'reference_id',
        'status',
        'locale_id',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'time',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function targetItem()
    {
        return $this->belongsTo(Comment::class, 'reference_id', 'id');
    }

    public function getTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
