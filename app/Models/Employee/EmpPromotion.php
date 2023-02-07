<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpPromotion extends Model
{
    protected $table= 'emp_promotions';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'emp_personals_id',
        'effective_date',
        'designation_id',
        'descriptions',
        'status',
        'user_id',
    ];

    public function personal()
    {
        return $this->belongsTo(EmpPersonal::class,'emp_personals_id','id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }
}
