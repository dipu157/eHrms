<?php

namespace App\Models\Employee;


use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Department;
use App\Models\Employee\Designation;
use App\Models\Employee\EmpPersonal;
use App\User;
use Illuminate\Support\Facades\Session;

class EmpRecomended extends Model
{
    protected $table= 'emp_recomended';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'department_id',
        'designation_id',
        'employee_id',
        'emp_personals_id',
        'effective_date',
        'promotion_name',
        'change_designame',
        'aditional_amt',
        'fixation_amt',
        'proposed_salary',
        'descriptions',
        'promoted',
        'user_id',
    ];
    public function personal()
    {
        return $this->belongsTo(EmpPersonal::class,'emp_personals_id','id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
       /// return $this->belongsTo(Department::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
