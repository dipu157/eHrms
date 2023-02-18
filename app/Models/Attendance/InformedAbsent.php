<?php

namespace App\Models\Attendance;

use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class InformedAbsent extends Model
{
    protected $table= 'informed_absent';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'status_id',
        'absent_year',
        'from_date',
        'to_date',
        'nods',
        'reason',
        'user_id',
        'status',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
}
