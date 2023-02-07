<?php

namespace App\Models\Payroll;

use App\Models\Common\OrgCalender;
use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class Arear extends Model
{
    protected $table= 'arears';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'amount',
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
