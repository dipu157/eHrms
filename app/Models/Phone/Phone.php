<?php

namespace App\Models\Phone;

use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Department;
use App\Models\Roster\DutyLocation;

class Phone extends Model
{
    protected $table= 'phones';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'used_by',
        'department_id',
        'phone_no',
        'location_id',
        'ip_address',
        'user_id',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function location()
    {
        return $this->belongsTo(DutyLocation::class,'location_id','id');
    }
}
