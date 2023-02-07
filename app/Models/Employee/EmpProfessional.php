<?php

namespace App\Models\Employee;

use App\Models\Attendance\DailyAttendance;
use App\Models\Common\Department;
use App\Models\Common\Section;
use App\Models\Common\WorkingStatus;
use App\Models\Hospitality\FoodBeverage;
use App\Models\Payroll\Arear;
use App\Models\Payroll\MonthlySalary;
use App\Models\Payroll\Bonus;
use App\Models\Payroll\SalarySetup;
use App\Models\Common\Division;
use App\Models\Roster\Roster;
use App\Models\Training\Trainee;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class EmpProfessional extends Model
{
    protected $table= 'emp_professionals';

    protected $guarded = ['id', 'created_at','updated_at'];

    protected $fillable = [
        'bank_acc_no',
        'bank_id',
        'card_no',
        'card_printed',
        'punch_exempt',
        'late_exempt',
        'company_id',
        'confirm_period',
        'confirm_probation',
        'contractEnd_date',
        'department_id',
        'designation_id',
        'base_designation_id',
        'employee_id',
        'pf_no',
        'emp_personals_id',
        'joining_date',
        'overtime',
        'overtime_note',
        'transport',
        'transport_note',
        'pay_grade',
        'pay_schale',
        'section_id',
        'status',
        'status_change_date',
        'user_id',
        'working_status_id',
        'doctor_special_id'
    ];

    public function personal()
    {
        return $this->belongsTo(EmpPersonal::class,'emp_personals_id','id');
    }

    public function history()
    {
        return $this->hasMany(EmpHistory::class,'employee_id','employee_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class)->withDefault();
    }

    public function section()
    {
        return $this->belongsTo(Section::class)->withDefault();
    }

    public function rosterEntry()
    {
        $dept_id = Session::get('session_user_dept_id');
        $dept_data = Department::query()->where('id',$dept_id)->first();

        return $this->hasOne(Roster::class,'employee_id','employee_id')
            ->where('r_year',$dept_data->roster_year)
            ->where('month_id',$dept_data->roster_month_id)
            ->where('status',false)
            ->withDefault();
    }

    public function roster()
    {
        return $this->hasOne(Roster::class,'employee_id','employee_id')->withDefault();
    }


    public function wStatus()
    {
        return $this->belongsTo(WorkingStatus::class,'working_status_id','id');
    }

    public function attendance()
    {
        return $this->hasMany(DailyAttendance::class,'employee_id','employee_id');
    }

    public function salary_properties()
    {
        return $this->hasOne(SalarySetup::class,'employee_id','employee_id')->withDefault();
    }
    public function recomended()
    {
        return $this->hasOne(EmpRecomended::class,'employee_id','employee_id')->withDefault();
    }
    public function trainees()
    {
        return $this->hasMany(Trainee::class,'employee_id','employee_id');
    }

    public function trainee()
    {
        return $this->hasOne(Trainee::class,'employee_id','employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->hasOne(FoodBeverage::class,'employee_id','employee_id')->withDefault();
    }

    public function salary()
    {
        return $this->hasOne(MonthlySalary::class,'employee_id','employee_id');
    }

    public function bonus()
    {
        return $this->hasOne(Bonus::class,'employee_id','employee_id');
    }

    public function arear()
    {
        return $this->hasOne(Arear::class,'employee_id','employee_id')->withDefault();
    }

    public function division()
    {
        return $this->belongsTo(Division::class)->withDefault();
    }

}
