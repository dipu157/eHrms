<?php

namespace App\Models\Attendance;

use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class PunchDetail extends Model
{
    protected $table= 'punch_details';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'device_id',
        'attendance_datetime',
        'late_allow',
        'status',
        'user_id',
    ];
    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
}
