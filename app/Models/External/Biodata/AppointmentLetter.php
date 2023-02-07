<?php

namespace App\Models\External\Biodata;

use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Department;
use App\Models\Employee\Designation;

class AppointmentLetter extends Model
{
    protected $table= 'appointment_letters';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'issue_number',
        'name',
        'fathers_name',
        'mothers_name',
        'mobile_no',
        'present_address',
        'permanent_address',
        'submission_date',
        'department_id',
        'designation_id',
        'salary_grade',
        'provision_salary',
        'regular_salary',
        'responsibility',
        'provision_period',
        'joining_date',
        'remarks',
        'status',
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
