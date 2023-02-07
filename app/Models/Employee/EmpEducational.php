<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpEducational extends Model
{
    protected $table= 'emp_educationals';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'emp_personals_id',
        'name',
        'description',
        'company_id',
        'institution',
        'passing_year',
        'result',
        'degree_type',
        'achievement_date',
        'status',
        'user_id',
    ];
}
