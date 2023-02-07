<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

class PublicHoliday extends Model
{
    protected $table= 'public_holidays';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'hYear',
        'from_date',
        'to_date',
        'count',
        'title',
        'description',
        'status',
        'user_id',
    ];
}
