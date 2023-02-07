<?php

namespace App\Http\Controllers\Leave;

use App\Models\Leaves\LeaveApplication;
use App\Models\Leaves\LeaveMaster;
use App\Models\Leaves\LeaveRegister;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Models\Attendance\PublicHoliday;
use Carbon\Carbon;
use App\Models\Common\OrgCalender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LeaveProcessController extends Controller
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
        if(check_privilege(28,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $period = OrgCalender::query()->where('company_id',$this->company_id)->where('salary_open','O')->first();

        return view('leave.index.leave-process-index',compact('period'));
    }


    public function process(Request $request)
    {

        if(check_privilege(702,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

       
        $period = OrgCalender::query()->where('company_id',$this->company_id)->where('salary_open','O')->first();

        $year = $period->calender_year;

        //dd($year);

        $employees = EmpProfessional::query()->where('company_id',$this->company_id)
              //  ->where('employee_id',12213111)
                ->whereIn('working_status_id',[1,2,8])
                ->with('personal')
                ->get();

        $leaves = LeaveMaster::query()
        			->where('company_id',$this->company_id)
        			->get();

        $g_holidays = PublicHoliday::query()->where('company_id',$this->company_id)
                    ->where('hYear',$year)
                    ->pluck('from_date');

        $g_holidays_lastDay = PublicHoliday::query()->where('company_id',$this->company_id)
                    ->where('hYear',$year)
                    ->max('from_date');

        $g_holidays_day = PublicHoliday::query()->where('company_id',$this->company_id)
                    ->where('hYear',$year)
                    ->select(DB::raw("SUM(count) as gholidays"))
                    ->pluck('gholidays');
        
        //dd($g_holidays_lastDay);

         LeaveRegister::query()->where('company_id',$this->company_id)
                 ->where('leave_year',$year+1)->delete();

        try{

        	foreach ($employees as $emp) {

                $emp_yearly_leave = LeaveRegister::query()
                                            ->where('emp_personals_id',$emp->emp_personals_id)
                                            ->where('leave_year',$year)
                                            ->with('type')
                                            ->get();

                //dd($emp_yearly_leave);

                $join_date = $emp->joining_date;


                $process_date = date('Y-m-d');

               // dd($process_date);

                $join_date_str = strtotime($join_date);
                $join_date_day = date("d", $join_date_str);
                $join_month_days = Carbon::parse($join_date)->daysInMonth;
                $join_month_work = $join_month_days - $join_date_day;

                $w_months = nb_mois($join_date,$process_date);

                $join_day=Carbon::parse($join_date);

                $process_day=Carbon::parse($process_date);

                $w_day=$join_day->diffInDays($process_day);

               // dd($w_day);

                if($join_date > $g_holidays_lastDay){

                    $count = $g_holidays_day[0] ;
                }else{

                    $count = 0;

                for ($i=0; $i<$g_holidays_day[0]; $i++) { 
                            
                    $count = $i ;

                    if($g_holidays[$i] > $join_date){

                    break;
                    }
                            
                } 
                }

                                         

               // dd($count);

                $total_gdays = $g_holidays_day[0] - $count ; 

               // dd($total_gdays);

                if($w_months >= 12){

                            $total_wDays = 365;
                            $total_wHolidays = 52;
                            $total_gHolidays = $g_holidays_day[0];
                }else{

                            $total_wDays = round($w_day);
                            $total_wHolidays = round($w_day/7);
                            $total_gHolidays = round($total_gdays);
                }

                $total_present = $total_wDays- round(($total_wHolidays + $total_gHolidays + $emp_yearly_leave[0]->leave_enjoyed + $emp_yearly_leave[1]->leave_enjoyed + $emp_yearly_leave[3]->leave_enjoyed + $emp_yearly_leave[4]->leave_enjoyed + $emp_yearly_leave[5]->leave_enjoyed + $emp_yearly_leave[6]->leave_enjoyed + $emp_yearly_leave[7]->leave_enjoyed+ $emp_yearly_leave[8]->leave_enjoyed + $emp_yearly_leave[9]->leave_enjoyed));

                $obtain_earnLeave = $total_present/18;

                if($obtain_earnLeave > 16){

                    $obtain_earnLeave = 16;
                }else{

                    $obtain_earnLeave = $obtain_earnLeave;
                }
                $earnLeave = round($emp_yearly_leave[3]->leave_balance + $obtain_earnLeave);

              //  dd($earnLeave);
                


        	foreach ($leaves as $leave) {
        		
        		if ($leave->id == 1) {
                        LeaveRegister::query()->updateOrCreate([
                    'company_id'=>$this->company_id,
                    'leave_year' => $year+1,
                    'emp_personals_id'=>$emp->emp_personals_id,
                    'leave_id'=>$leave->id,
                    'leave_eligible'=>10,
                    'leave_enjoyed'=>0,
                    'leave_balance'=>10,                    
                    'status' =>1,
                ]);
                    }elseif ($leave->id == 2) {
                        LeaveRegister::query()->updateOrCreate([
                    'company_id'=>$this->company_id,
                    'leave_year' => $year+1,
                    'emp_personals_id'=>$emp->emp_personals_id,
                    'leave_id'=>$leave->id,
                    'leave_eligible'=>14,
                    'leave_enjoyed'=>0,
                    'leave_balance'=>14,                    
                    'status' =>1,
                ]);
                    }elseif ($leave->id == 4) {
                        LeaveRegister::query()->updateOrCreate([
                    'company_id'=>$this->company_id,
                    'leave_year' => $year+1,
                    'emp_personals_id'=>$emp->emp_personals_id,
                    'leave_id'=>$leave->id,
                    'leave_eligible'=>$earnLeave,
                    'leave_enjoyed'=>0,
                    'leave_balance'=>$earnLeave,                    
                    'status' =>1,
                ]);
                    }else{

                        LeaveRegister::query()->updateOrCreate([
                    'company_id'=>$this->company_id,
                    'leave_year' => $year+1,
                    'emp_personals_id'=>$emp->emp_personals_id,
                    'leave_id'=>$leave->id,
                    'leave_eligible'=>0,
                    'leave_enjoyed'=>0,
                    'leave_balance'=>0,                    
                    'status' =>1,
                ]);

                        set_time_limit(0);
                    }

                
        		}
        	}
        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $emp->employee_id.$error], 404);
        }

        DB::commit();

        return redirect()->action('Leave\LeaveProcessController@index')->with('success','Leave Has Been Processed');
    }
}
