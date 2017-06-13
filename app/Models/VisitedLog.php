<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VisitedLog extends Model
{
    protected $table = 'visited_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'relate_table_id',
        'relate_table_type',
        'start_date',
        'count',
    ];

    public function relateTable()
    {
        return $this->morphTo();
    }
}
