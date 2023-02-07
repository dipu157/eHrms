<?php

namespace App\Models\Attendance;

use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class OnDuty extends Model
{
    protected $table= 'on_duties';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'duty_year',
        'employee_id',
        'from_date',
        'to_date',
        'nods',
        'duty_place',
        'application_time',
        'reason',
        'recommend_id',
        'recommend_date',
        'approver_id',
        'approve_date',
        'description',
        'posted',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
}
