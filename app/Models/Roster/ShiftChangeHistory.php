<?php

namespace App\Models\Roster;

use Illuminate\Database\Eloquent\Model;

class ShiftChangeHistory extends Model
{
    protected $table= 'shift_change_histories';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'change_date',
        'shift_id',
        'name',
        'short_name',
        'from_time',
        'to_time',
        'duty_hour',
        'end_next_day',
        'status',
        'user_id',
    ];
}
