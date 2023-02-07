<?php

namespace App\Models\Attendance;

use App\Models\Common\Department;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveMaster;
use App\Models\Roster\Shift;
use App\Models\Roster\DutyLocation;
use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    protected $table= 'daily_attendances';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'department_id',
        'device_id',
        'attendance_datetime',
        'attend_date',
        'entry_date',
        'entry_time',
        'shift_entry_time',
        'exit_date',
        'exit_time',
        'shift_exit_time',
        'attend_status',
        'night_duty',
        'late_flag',
        'late_allow',
        'late_minute',
        'over_time',
        'overtime_hour',
        'leave_flag',
        'leave_id',
        'holiday_flag',
        'offday_flag',
        'offday_present',
        'shift_id',
        'location_id',
        'compensate',
        'alter_leave_date',
        'in_process',
        'manual_update',
        'manual_updated_by',
        'manual_update_remarks',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function leave()
    {
        return $this->belongsTo(LeaveMaster::class,'leave_id','id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function location()
    {
        return $this->belongsTo(DutyLocation::class,'location_id','id');
    }



}
