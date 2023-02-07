<?php

namespace App\Models\Payroll;

use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class MonthlySalary extends Model
{
    protected $table= 'monthly_salaries';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'department_id',
        'period_id',
        'basic',
        'house_rent',
        'medical',
        'entertainment',
        'conveyance',
        'other_allowance',
        'gross_salary',
        'cash_salary',
        'paid_days',
        'earned_salary',
        'increment_amt',
        'arear_amount',
        'overtime_hour',
        'overtime_amount',
        'payable_salary',
        'income_tax',
        'advance',
        'mobile_others',
        'stamp_fee',
        'food_charge',
        'net_salary',
        'bank_id',
        'account_no',
 'tcs_account_no',
        'tds_id',
        'checker_id',
        'check_date',
        'check_status',
        'manual_update',
        'final',
        'withheld',
        'reason',
        'remarks',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }

    public function heldup()
    {
        return $this->belongsTo(Heldup::class,'employee_id','employee_id');
    }
}
