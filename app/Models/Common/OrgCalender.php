<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class OrgCalender extends Model
{
    protected $table= 'org_calenders';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'calender_year',
        'month_id',
        'c_month_id',
        'month_name',
        'start_from',
        'ends_on',
        'nods',
        'salary_open',
        'salary_update',
        'food_open',
        'status',
        'user_id',
    ];
}
