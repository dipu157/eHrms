<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table= 'sections';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'department_id',
        'section_code',
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

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
