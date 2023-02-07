<?php

namespace App\Models\Payroll;

use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class SalarySetup extends Model
{
    protected $table= 'salary_setups';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'ot_basic',
        'basic',
        'house_rent',
        'medical',
        'entertainment',
        'conveyance',
        'gross_salary',
        'cash_salary',
        'other_allowance',
        'special_allowance',
        'bank_id',
        'account_no',
 'tcs_account_no',
        'tds',
        'checker_id',
        'check_date',
        'check_status',
        'income_tax',
        'advance',
        'mobile_others',
        'stamp_fee',
        'pf_own',
        'punishment',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
}
