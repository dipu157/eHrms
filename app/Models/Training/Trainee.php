<?php

namespace App\Models\Training;
use App\User;

use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    protected $table= 'trainees';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'training_schedule_id',
        'employee_id',
        'attended',
        'evaluation',
        'evaluated_by',
        
        'description',
        'training_date',
        'start_time',
        'end_time',
        'reason',
'approval_status',
'recommended_date',
        'approver_id',
        'finalize_by',
        'finalize_at',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        
    ];

    public function trainingSch()
    {
        return $this->belongsTo(TrainingSchedule::class,'training_schedule_id','id');
    }
  
    public function employee()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
    public function training()
    {
        return $this->belongsTo(Training::class);
    }
    public function approver()
    {
        return $this->belongsTo(User::class,'approver_id','id');
    }
    public function getDepartmentAttribute()
    {
        return $this->employee->department_id;
    }





}
