<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpExperience extends Model
{
    protected $table= 'emp_experiences';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'emp_personals_id',
        'job_ref_company',
        'designation',
        'length',
        'from_date',
        'to_date',
        'last_pay_salary',
        'status',
        'user_id',
    ];
}
