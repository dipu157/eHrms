<?php

namespace App\Http\Controllers\Payroll\Salary;

use App\Models\Attendance\DailyAttendance;
use App\Models\Payroll\SalarySetup;
use App\Models\Common\OrgCalender;
use App\Models\Employee\EmpProfessional;
use App\Models\Hospitality\FoodBeverage;
use App\Models\Overtime\OvertimeSetup;
use App\Models\Payroll\Increment;
use App\Models\Payroll\Arear;
use App\Models\Payroll\MonthlySalary;
use App\Models\Payroll\Heldup;
use App\Models\Payroll\Bonus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryProcessController extends Controller
{
    public $company_id;
    public $user_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->company_id = Auth::user()->company_id;
            $this->user_id = Auth::id();

            return $next($request);
        });
    }

    public function index()
    {
        if(check_privilege(702,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $period = OrgCalender::query()->where('company_id',$this->company_id)->where('salary_open','O')->first();
        return view('payroll.salary.salary-process-index',compact('period'));
    }

    public function process(Request $request)
    {

        if(check_privilege(702,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

       
        $period = OrgCalender::query()->where('company_id',$this->company_id)->where('salary_open','O')->first();

        
        DB::beginTransaction();

    if ($request['type_id'] == 1) {

        try {

            $start = $period->start_from;
            $end = $period->ends_on;
            $nods = $period->nods;

            $employees = EmpProfessional::query()->where('company_id',$this->company_id)
                ->whereIn('working_status_id',[1,2,8])
                ->orWhere(function ($query) use($start) {
                    $query->whereIn('working_status_id',[3,4,5,6,7,9,10,11])->where('status_change_date','>',$start);
                })->with('personal')->with('salary_properties')
                ->get();

            $foods = FoodBeverage::query()->where('c_year',$period->calender_year)
                ->where('amount','>', 0)->where('status',false)
                ->where('month_id',$period->month_id)->get();

            $overtime = OvertimeSetup::query()->where('company_id',$this->company_id)
                ->whereBetween('ot_date',[$start,$end])->where('actual_overtime_hour','>',0)
                ->select('employee_id', DB::Raw('sum(actual_overtime_hour) as ot_hour'))
                ->groupBy('employee_id')
                ->get();

            $days = Heldup::query()->where('period_id',$period->id)->get();


            $increments = Increment::query()->where('company_id',$this->company_id)
                ->where('period_id',$period->id)->get();

            $arears = Arear::query()->where('company_id',$this->company_id)
                ->where('period_id',$period->id)->get();

               // dd($arears);

            $attendance = DailyAttendance::query()
                ->where('company_id',$this->company_id)
                ->whereBetween('attend_date',[$period->start_from,$period->ends_on])
                ->select('department_id','employee_id',
                    DB::raw('sum(case when attend_status = "P" and offday_flag = false and holiday_flag = false and leave_flag=false then 1 else 0 end) as present'),
                    DB::raw('sum(case when offday_flag = true and leave_flag=false and holiday_flag=false then 1 else 0 end) as offday'),
                    DB::raw('sum(case when leave_id = 1 then 1 else 0 end) as casual'),
                    DB::raw('sum(case when leave_id = 4 then 1 else 0 end) as earn'),
                    DB::raw('sum(case when leave_id = 2 then 1 else 0 end) as sick'),
                    DB::raw('sum(case when leave_id = 3 then 1 else 0 end) as alterLeave'),
                    DB::raw('sum(case when leave_id = 8 then 1 else 0 end) as spLeave'),
                    DB::raw('sum(case when leave_id = 9 then 1 else 0 end) as wpLeave'),
                    DB::raw('sum(case when leave_id = 6 then 1 else 0 end) as QLeave'),
                    DB::raw('floor(sum(case when late_flag = true then 1 else 0 end)/3) as lateCount'),
                    DB::raw('sum(case when holiday_flag = true and leave_flag=false then 1 else 0 end) as holiday'),
                    DB::raw('sum(case when (late_flag = true) and (late_allow = false) then 1 else 0 end) as late_count'),
                    DB::raw('sum(overtime_hour) as overtime_hour'),
                    DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                )
                ->groupBy('department_id','employee_id')
                ->orderBy('employee_id','ASC')
                ->with('department')
                ->get();

            MonthlySalary::query()->where('company_id',$this->company_id)
                ->where('period_id',$period->id)->delete();

            foreach ($employees as $emp)
            {

                $ot_hour = 0;
                $ot_amt = 0;

                $f_charge = $foods->where('employee_id',$emp->employee_id)->first();
                $charge = isset($f_charge->amount) ? $f_charge->amount : 0;

                $attend = $attendance->where('employee_id',$emp->employee_id)->first();
                $ot_hour = $overtime->where('employee_id',$emp->employee_id)->first();

                // dd($ot_hour);

                if(!empty($ot_hour))
                {
                    $ot_amt = $emp->salary_properties->ot_basic > 0 ? round((($emp->salary_properties->ot_basic)/208)*$ot_hour->ot_hour*2) : round((($emp->salary_properties->basic)/208)*$ot_hour->ot_hour*2);
                }

                $increment_amount = $increments->where('employee_id',$emp->employee_id)->first();

                $arear_amount = $arears->where('employee_id',$emp->employee_id)->first();


                $update_heldup = Heldup::query()->where('period_id',$period->id)->where('withheld',1)->where('employee_id',$emp->employee_id)->first();

               // dd($update_heldup);

              $p_daysf = $days->where('employee_id',$emp->employee_id)->first();

              $p_days = !empty($p_daysf) ? ($p_daysf->paid_days) : (empty($attend) ? 0 : (($attend->present + $attend->offday + $attend->holiday + $attend->casual + $attend->spLeave + $attend->earn + $attend->sick + $attend->QLeave + $attend->alterLeave) - ($attend->lateCount)));
              $p_days = $p_days < 1 ? 0 : $p_days;

              $actual_heldup = !empty($update_heldup) ? ($update_heldup->withheld) : 0;

             // dd($actual_heldup);

                MonthlySalary::query()->insert([
                    'company_id'=>$this->company_id,
                    'employee_id' => $emp->employee_id,
                    'department_id' => $emp->department_id,
                    'period_id'=>$period->id,
                    'basic'=>$emp->salary_properties->basic ?? 0,
                    'house_rent'=>$emp->salary_properties->house_rent ?? 0,
                    'medical'=>$emp->salary_properties->medical ?? 0,
                    'entertainment'=>$emp->salary_properties->entertainment ?? 0,
                    'conveyance'=>$emp->salary_properties->conveyance ?? 0,
                    'other_allowance'=>$emp->salary_properties->other_allowance ?? 0,
                    'gross_salary'=>$emp->salary_properties->gross_salary ?? 0,
                    'overtime_hour' => isset($ot_hour->ot_hour) ? $ot_hour->ot_hour : 0,
                    'overtime_amount' => $ot_amt,
                    'cash_salary'=>$emp->salary_properties->cash_salary ?? 0,
                    'paid_days'=>$p_days,
                    'earned_salary' =>round(($emp->salary_properties->gross_salary/$nods)*$p_days),
                    'increment_amt'=>$increment_amount->increment_amount ?? 0,
                    'arear_amount'=>$arear_amount->amount ?? 0,
                    'income_tax'=>$emp->salary_properties->income_tax ?? 0,
                    'advance'=>$emp->salary_properties->advance ?? 0,
                    'mobile_others'=>$emp->salary_properties->mobile_others ?? 0,
                    'stamp_fee'=>$emp->salary_properties->stamp_fee ?? 0,
                    'food_charge'=>$charge,
                    'payable_salary'=>0,
                    'bank_id'=>$emp->salary_properties->bank_id ?? 1,
                    'account_no'=>$emp->salary_properties->account_no ?? 'N',
                 'tcs_account_no'=>$emp->salary_properties->tcs_account_no ?? 'N',
                    'tds_id'=>$emp->salary_properties->tds ?? 'N',
                    'withheld'=>$actual_heldup,
                    'user_id'=>$this->user_id,
                    'remarks'=>$emp->personal->full_name,
                ]);

            }

            MonthlySalary::query()->where('company_id',$this->company_id)
                ->where('period_id',$period->id)
                ->update(['payable_salary'=>DB::Raw('earned_salary + overtime_amount + increment_amt + arear_amount'),
                    'net_salary'=>DB::Raw('earned_salary + overtime_amount + increment_amt + arear_amount - income_tax - advance - mobile_others - stamp_fee - food_charge')
                    ]);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $emp->employee_id.$error], 404);
        }

        DB::commit();

        return redirect()->action('Payroll\Salary\SalaryProcessController@index')->with('success','Salary Has Been Processed');

    } if ($request['type_id'] == 2) {

        ini_set('max_execution_time', 0);

        try {

            $start = '2021-06-01';
            $end = '2022-05-31';
            $endstr = strtotime('2022-05-31');
            $start_count = date("Y-m-d", strtotime("-1 year", $endstr));

            // dd($start_count);

            $employees = EmpProfessional::query()->where('company_id',$this->company_id)
                ->whereIn('working_status_id',[1,2,8])
                ->orWhere(function ($query) use($start) {
                    $query->whereIn('working_status_id',[3,4,5,6,7,9,10,11,12])->where('status_change_date','>',$start);
                })->with('personal')->with('salary_properties')
                ->get();

            

            //dd($employees);

            Bonus::query()->where('company_id',$this->company_id)
                ->where('period_id',$period->id)->delete();

            foreach ($employees as $emp)
            {
$attendance = DailyAttendance::query()
               ->where('company_id',$this->company_id)
                ->where('employee_id',$emp->employee_id)
               ->whereBetween('attend_date',[$start_count,$end])
               ->select(
                    DB::raw('sum(case when leave_id = 9 then 1 else 0 end) as wpLeave'),
                     DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                )->first();

              $absent = $attendance->wpLeave + $attendance->absent ;

                $bonus_amt = 0;
                $per_day_bonus = 0;
                $joining_date = $emp->joining_date;
                $basic = $emp->salary_properties->basic;
                $stamp_fee = $emp->salary_properties->stamp_fee;

                $join_date_str = strtotime($joining_date);
                $join_date_day = date("d", $join_date_str);
                $join_month_days = Carbon::parse($joining_date)->daysInMonth;
                $join_month_work = $join_month_days - $join_date_day;
                
                $w_months = nb_mois($emp->joining_date,$end);

                //dd($w_months);

            

            if ($w_months >= 12) {
                
                $bonus_amt = $basic*12;
                $per_day_bonus = $basic/30;
              $deduct_bonus = $per_day_bonus*$absent;
               $bonus = $bonus_amt - $deduct_bonus;
               $net_bonus = $bonus/12;


            }

            if ($w_months < 12) {

                $FMB = ($basic/$join_month_days)*($join_month_work+1);     
                $other_month_bon = $basic*$w_months;
                
                $T_bonus = $FMB+$other_month_bon;
                
               

              $per_day_bonus = $basic/30;
             $deduct_bonus = $per_day_bonus*$absent;
              $bonus = $T_bonus - $deduct_bonus;
              $net_bonus = $bonus/12;
            }

            if ($net_bonus < 1000) {
                
                $net_bonus =1000 ;
            }

            $update_heldup = Heldup::query()->where('period_id',$period->id)->where('withheld',1)->where('employee_id',$emp->employee_id)->first();

            //dd($update_heldup);

            $actual_heldup = !empty($update_heldup) ? ($update_heldup->withheld) : 0;

            $end_month_str = strtotime('2022-05-31');

            if ( $join_date_str < $end_month_str)
            {
                Bonus::query()->insert([
                    'company_id'=>$this->company_id,
                    'employee_id' => $emp->employee_id,
                    'period_id'=>$period->id,
                    'basic'=>$emp->salary_properties->basic ?? 0,
                    'net_bonus'=>$net_bonus -$stamp_fee ?? 0,
                    'bonus'=> $net_bonus  ?? 0,
                    'stamp_fee'=>$stamp_fee ?? 0,
                    'bank_id'=>$emp->salary_properties->bank_id ?? 1,
                    'account_no'=>$emp->salary_properties->account_no ?? 'N',
'tcs_account_no'=>$emp->salary_properties->tcs_account_no ?? 'N',
                    'withheld'=>$actual_heldup,
                    'user_id'=>$this->user_id,
                    'remarks'=>$emp->personal->full_name,
                ]);
            }
            }


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $emp->employee_id.$error], 404);
        }

        DB::commit();


        return redirect()->action('Payroll\Salary\SalaryProcessController@index')->with('success','Bonus Has Been Processed');
    }

    }
}
