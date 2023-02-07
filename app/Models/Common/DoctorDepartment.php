<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class DoctorDepartment extends Model
{
    protected $table= 'doctor_department';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'doctorDepartment_code',
        'name',
        'short_name',
        'description',
        'started_from',
        'report_to',
        'approval_authority',
        'headed_by',
        'second_man',
        'email',
        'middle_name',
        'emp_count',
        'approved_manpower',
        'top_rank',
        'status',
        'user_id',
    ];
}
