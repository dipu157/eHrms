<?php

namespace App\Models\Employee;

use App\Models\Common\Department;
use App\Models\Common\Division;
use App\Models\Common\Section;
use Illuminate\Database\Eloquent\Model;

class EmpPostingHistory extends Model
{
    protected $table= 'emp_posting_histories';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'division_id',
        'department_id',
        'section_id',
        'emp_personals_id',
        'posting_start_date',
        'posting_end_date',
        'special',
        'section_id',
        'charge_type',
        'report_to',
        'posting_notes',
        'status',
        'descriptions',
        'user_id',
    ];

    public function personal()
    {
        return $this->belongsTo(EmpPersonal::class,'emp_personals_id','id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function report()
    {
        return $this->belongsTo(EmpPersonal::class,'report_to','id');
    }

}
