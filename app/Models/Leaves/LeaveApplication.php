<?php

namespace App\Models\Leaves;

use App\Models\Common\Department;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class LeaveApplication extends Model
{
    protected $table= 'leave_applications';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'leave_year',
        'emp_personals_id',
        'leave_id',
        'from_date',
        'nods',
        'to_date',
        'duty_date',
        'application_time',
        'reason',
        'location',
        'alternate_id',
        'alternate_submit',
        'approver_id',
        'approve_date',
        'recommend_id',
        'recommend_date',
        'status',
        'user_id',
    ];

    public function personal()
    {
        return $this->belongsTo(EmpPersonal::class,'emp_personals_id','id');
    }

    public function alternate()
    {
        return $this->belongsTo(EmpProfessional::class,'alternate_id','employee_id');
    }

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'emp_personals_id','emp_personals_id');
    }

    public function recommend()
    {
        return $this->belongsTo(EmpPersonal::class,'recommend_id','id');
    }

    public function type()
    {
        return $this->belongsTo(LeaveMaster::class,'leave_id','id');
    }

// Geting Specific Deparatments Leave Applicants

    public function userProf()
    {
        return $this->hasManyThrough(
            'App\Models\Employee\EmpProfessional',
            'App\Models\Employee\EmpPersonal',
            'id', // Foreign key on users table...
            'emp_personals_id', // Foreign key on posts table...
            'emp_personals_id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }

}
