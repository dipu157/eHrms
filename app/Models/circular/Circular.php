<?php

namespace App\Models\Circular;

use App\Models\Common\Department;
use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    protected $table= 'job_circular';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'circular_name',
        'department_id',
        'expire_date',
        'status',
        'user_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
