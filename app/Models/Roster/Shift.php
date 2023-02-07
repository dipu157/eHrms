<?php

namespace App\Models\Roster;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table= 'shifts';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'shift_code',
        'name',
        'short_name',
        'session_id',
        'from_time',
        'to_time',
        'duty_hour',
        'end_next_day',
        'effective_date',
        'description',
        'terminal',
        'status',
        'user_id',
        'Serial',
    ];
}
