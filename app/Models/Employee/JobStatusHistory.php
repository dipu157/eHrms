<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class JobStatusHistory extends Model
{
    protected $table= 'job_status_histories';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'emp_personals_id',
        'status_id',
        'start_date',
        'end_date',
        'change_notes',
        'descriptions',
        'user_id',
    ];

    public function personal()
    {
        return $this->belongsTo(EmpPersonal::class,'emp_personals_id','id');
    }
}
