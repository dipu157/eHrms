<?php

namespace App\Models\Leaves;

use Illuminate\Database\Eloquent\Model;

class LeaveRegister extends Model
{
    protected $table= 'leave_registers';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'leave_year',
        'emp_personals_id',
        'leave_id',
        'leave_eligible',
        'leave_enjoyed',
        'leave_balance',
        'last_leave',
        'status',
        'user_id',
    ];

    public function type()
    {
        return $this->belongsTo(LeaveMaster::class,'leave_id','id');
    }
}
