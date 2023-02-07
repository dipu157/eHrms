<?php

namespace App\Models\Hospitality;

use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class FoodBeverage extends Model
{
    protected $table= 'food_beverages';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'c_year',
        'month_id',
        'amount',
        'deduction_type',
        'description',
        'approver_id',
        'approved_at',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }
}
