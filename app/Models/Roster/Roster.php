<?php

namespace App\Models\Roster;

use App\Models\Common\Department;
use App\Models\Employee\EmpProfessional;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $table= 'rosters';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'company_id',
        'employee_id',
        'r_year',
        'month_id',
        'department_id',
        'day_01',
        'day_02',
        'day_03',
        'day_04',
        'day_05',
        'day_06',
        'day_07',
        'day_08',
        'day_09',
        'day_10',
        'day_11',
        'day_12',
        'day_13',
        'day_14',
        'day_15',
        'day_16',
        'day_17',
        'day_18',
        'day_19',
        'day_20',
        'day_21',
        'day_22',
        'day_23',
        'day_24',
        'day_25',
        'day_26',
        'day_27',
        'day_28',
        'day_29',
        'day_30',
        'day_31',
        'loc_01',
        'loc_02',
        'loc_03',
        'loc_04',
        'loc_05',
        'inserted_by',
        'inserted_date',
        'approved_by',
        'approved_date',
        'updated_by',
        'updated_date',
        'status',
        'user_id',
    ];

    public function professional()
    {
        return $this->belongsTo(EmpProfessional::class,'employee_id','employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class,'day_01','id');
    }

    public function location()
    {
        return $this->belongsTo(DutyLocation::class,'loc_05','id');
    }
}
