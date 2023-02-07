<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\EmpProfessional;

class Bonus extends Model
{
     protected $table= 'bonus';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'period_id',
        'basic',
        'bonus',
        'bonus_days',
        'stamp_fee',
        'bank_id',
        'checker_id',
        'check_date',
        'check_status',
        'withheld',
        'remarks',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
}
