<?php

namespace App\Models\Employee;


use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Department;
use App\User;
use Illuminate\Support\Facades\Session;

class EmpHistory extends Model
{
    protected $table= 'emp_histories';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'department_id',
        'designation_id',
        'employee_id',
        'emp_personals_id',
        'effective_date',
        'basic',
        'gross_salary',
        'descriptions',
        'user_id',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
