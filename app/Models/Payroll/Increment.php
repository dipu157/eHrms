<?php

namespace App\Models\Payroll;

use App\Models\Common\OrgCalender;
use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class Increment extends Model
{
    protected $table= 'increments';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'effective_from',
        'due_months',
        'previous_basic',
        'increased_basic',
        'increment_amount',
        'period_id',
        'description',
        'posted',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }

    public function period()
    {
        return $this->belongsTo(OrgCalender::class);
    }
}
