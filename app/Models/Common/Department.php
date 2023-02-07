<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table= 'departments';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'division_id',
        'department_code',
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
        'roster_year',
        'roster_month_id',
        'leave_steps',
        'status',
        'user_id',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class,'division_id','id');
    }
}
