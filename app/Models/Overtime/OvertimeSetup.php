<?php

namespace App\Models\Overtime;

use App\Models\Employee\EmpProfessional;
use App\User;
use Illuminate\Database\Eloquent\Model;

class OvertimeSetup extends Model
{
    protected $table= 'overtime_setups';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'ot_type',
        'ot_date',
        'entry_time',
        'exit_date',
        'exit_time',
        'ot_hour',
        'overtime_from_punch',
        'actual_overtime_hour',
        'reason',
        'reject_Reason',
        'duty_status',
        'approval_status',
        'approver_id',
        'recommended_date',
        'finalize_by',
        'finalize_at',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function approver()
    {
        return $this->belongsTo(User::class,'approver_id','id');
    }

    public function finalize()
    {
        return $this->belongsTo(User::class,'finalize_by','id');
    }

}
