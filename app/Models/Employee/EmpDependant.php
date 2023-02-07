<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpDependant extends Model
{
    protected $table= 'emp_dependants';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'emp_personals_id',
        'name',
        'dependant_type',
        'date_of_birth',
        'age',
        'status',
        'user_id',
    ];
}
