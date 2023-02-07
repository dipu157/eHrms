<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\EmpProfessional;

class Heldup extends Model
{
    protected $table= 'heldup';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [

        'company_id',
        'employee_id',
        'period_id',
        'withheld',
        'paid_days',
        'reason',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
}
