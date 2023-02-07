<?php

namespace App\Models\Employee;

use App\Models\Common\Department;
use App\Models\Leaves\LeaveApplication;
use App\Models\Leaves\LeaveRegister;
use App\User;
use Illuminate\Database\Eloquent\Model;

class EmpPersonal extends Model
{
    protected $table= 'emp_personals';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'biography',
        'blood_group',
        'company_id',
        'dob',
        'email',
        'father_name',
        'first_name',
        'full_name',
        'gender',
        'religion_id',
        'is_printed',
        'last_education',
         'education_year',
        'last_name',
        'middle_name',
        'mobile',
        'mother_name',
        'm_address',
        'm_district',
        'm_police_station',
        'm_post_code',
        'national_id',
        'phone',
        'photo',
        'pm_address',
        'pm_district',
        'pm_police_station',
        'pm_post_code',
        'prof_speciality',
        'pr_address',
        'pr_district',
        'pr_police_station',
        'pr_post_code',
        'signature',
        'status',
        'title_id',
        'user_id'
    ];

    public function title()
    {
        return $this->belongsTo(Title::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function professional()
    {
        return $this->hasOne(EmpProfessional::class,'emp_personals_id','id')->withDefault();
    }


    public function RosterRelation()
    {
        // Call the thirdModelRelation method found in the Second Model
        return $this->professional->roster;
    }



    public function prof_dept()
    {
        return $this->hasMany(EmpProfessional::class,'emp_personals_id','id')->withDefault();
    }

    public function dependant()
    {
        return $this->hasMany(EmpDependant::class,'emp_personals_id','id');
    }

    public function education()
    {
        return $this->hasMany(EmpEducational::class,'emp_personals_id','id');
    }

    public function posting()
    {
        return $this->hasMany(EmpPostingHistory::class,'emp_personals_id','id');
    }

    public function promotion()
    {
        return $this->hasMany(EmpPromotion::class,'emp_personals_id','id');
    }

    public function leave()
    {
        return $this->hasMany(LeaveRegister::class,'emp_personals_id','id');
    }

    public function leaveApp()
    {
        return $this->hasMany(LeaveApplication::class,'emp_personals_id','id');
    }

    public function leaveStatus()
    {
        return $this->hasMany(LeaveApplication::class,'emp_personals_id','id');
    }

    public function getFoolNameAttribute($value)
    {
        $value = $this->first_name.' '.$this->middle_name.' '.$this->last_name;
        return $value;
    }
}
