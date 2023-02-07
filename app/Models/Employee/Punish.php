<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Department;

class Punish extends Model
{
    protected $table= 'punishes';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'emp_personals_id',
        'effective_date',
        'punish_id',
        'department_id',
        'descriptions',
        'status',
        'user_id',
    ];

    public function personal()
    {
        return $this->belongsTo(EmpPersonal::class,'emp_personals_id','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
