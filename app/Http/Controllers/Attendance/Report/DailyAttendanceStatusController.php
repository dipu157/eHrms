<?php

namespace App\Http\Controllers\Attendance\Report;

use App\Models\Attendance\DailyAttendance;
use App\Models\Employee\EmpProfessional;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyAttendanceStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->company_id = Auth::user()->company_id;
            $this->user_id = Auth::id();

            return $next($request);
        });
    }

    public function index(Request $request)
    {

        if (check_privilege(41, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = null;
        $report_date = null;

        if($request->filled('report_date'))
        {

            $report_date = Carbon::createFromFormat('d-m-Y',$request['report_date'])->format('Y-m-d');


                switch ($request['action'])
                {
    
    
                    case 'print':
         
            $data = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->select(DB::Raw('count(employee_id) as emp_count'),
                DB::raw('sum(case when attend_status = "P" then 1 else 0 end) as present'),
                DB::raw('sum(case when attend_status = "P" and shift_id = "1" then 1 else 0 end) as No_Roaster_present'),
                DB::raw('sum(case when attend_status = "P" and shift_id in("3","6","7","10","13","17","22","23","24","25","28","33","35","36","38") then 1 else 0 end) as Morning'),
                DB::raw('sum(case when attend_status = "P" and shift_id in("4","8","12","14","15","21","27","30","31","39") then 1 else 0 end) as Evening'),
                DB::raw('sum(case when attend_status = "P" and shift_id in("5","9","11","16","26","29","32","34","37") then 1 else 0 end) as Night'),
                DB::raw('sum(case when attend_status = "P" and shift_id ="2" then 1 else 0 end) as General'),
                DB::raw('sum(case when leave_flag = false and shift_id = "1" and attend_status = "A" then 1 else 0 end) as offday'),
                DB::raw('sum(case when leave_flag = true and attend_status = "A"  then 1 else 0 end) as n_leave'),
                DB::raw('sum(case when holiday_flag = true and attend_status = "A" then 1 else 0 end) as holiday'),
                DB::raw('sum(case when attend_status = "R" then 1 else 0 end) as next_roster'),
                DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false  and shift_id != "1" then 1 else 0 end) as absent'),
                DB::raw('sum(case when attend_status = "A" and shift_id in("5","9","11","16","26","29","32","34","37") then 1 else 0 end) as NightAb')
            )
          
            ->with('department')
            ->get();
  
                            $view = \View::make('attendance.report.pdf.daily-attendance-status-pdf', compact('data', 'report_date', 'shifts','employees','department'));
                            $html = $view->render();
                    
                            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                            ini_set('max_execution_time', 900);
                            ini_set('memory_limit', '1024M');
                            ini_set("output_buffering", 10240);
                            ini_set('max_input_time',300);
                            ini_set('default_socket_timeout',300);
                            ini_set('pdo_mysql.cache_size',4000);
                            ini_set('pcre.backtrack_limit', 5000000);
                           
                            $pdf::SetMargins(20, 5, 5,0);
                    
                            $pdf::AddPage();
                    
                            $pdf::writeHTML($html, true, false, true, false, '');
                            $pdf::Output('DailyAttendenceStatus.pdf');
            
                           
    
                    break;
                    case 'preview':

                        $data = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->select(DB::Raw('count(employee_id) as emp_count'),
                            DB::raw('sum(case when attend_status = "P" then 1 else 0 end) as present'),
                            DB::raw('sum(case when attend_status = "P" and shift_id = "1" then 1 else 0 end) as No_Roaster_present'),
                            DB::raw('sum(case when attend_status = "P" and shift_id in("3","6","7","10","13","17","22","23","24","25","28","33","35","36","38") then 1 else 0 end) as Morning'),
                            DB::raw('sum(case when attend_status = "P" and shift_id in("4","8","12","14","15","21","27","30","31") then 1 else 0 end) as Evening'),
                            DB::raw('sum(case when attend_status = "P" and shift_id in("5","9","11","16","26","29","32","34","37") then 1 else 0 end) as Night'),
                            DB::raw('sum(case when attend_status = "P" and shift_id ="2" then 1 else 0 end) as General'),
                            DB::raw('sum(case when leave_flag = false and shift_id = "1" and attend_status = "A" then 1 else 0 end) as offday'),
                            DB::raw('sum(case when leave_flag = true and attend_status = "A"  then 1 else 0 end) as n_leave'),
                            DB::raw('sum(case when holiday_flag = true and attend_status = "A" then 1 else 0 end) as holiday'),
                            DB::raw('sum(case when attend_status = "R" then 1 else 0 end) as next_roster'),
                            DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false  and shift_id != "1" then 1 else 0 end) as absent'),
DB::raw('sum(case when attend_status = "A" and shift_id in("5","9","11","16","26","29","32","34","37") then 1 else 0 end) as NightAb')
                        )
                        ->with('department')
                        ->get();

                        return view('attendance.report.daily-attendance-status-index',compact('data','report_date'));

                    break;
                }

        }



        return view('attendance.report.daily-attendance-status-index',compact('data','report_date'));
    }


 public function statusPrint($status,$date)
    {
        
        $report_date = Carbon::createFromFormat('Y-m-d',$date)->format('Y-m-d');

        switch ($status)
        {

            case 'present':

                $data = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)
                    ->where('leave_flag',false)
                    ->where('attend_status','P')
                    ->with('professional')
                    ->orderBy('shift_id')
                    ->get();

                $departments = $data->unique('department_id');

                $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)->where('leave_flag',false)
                    ->where('attend_status','P')
                    ->with('professional')
                    ->selectRaw('department_id, count(employee_id) as emp_count')
                    ->groupBy('department_id')
                    ->get();

                break;
                case 'No_Roaster_present':

                $data = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)
                    ->where('leave_flag',false)
                    ->where('offday_flag',true)
                    ->where('attend_status','P')
                    ->with('professional')
->orderBy('entry_time')
                    ->get();

                $departments = $data->unique('department_id');

                $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)->where('leave_flag',false)
                    ->where('attend_status','P')
                    ->where('offday_flag',true)
                    ->with('professional')
                    ->selectRaw('department_id, count(employee_id) as emp_count')
                    ->groupBy('department_id')
                    ->get();

                break;
                case 'General':

                    $data = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->where('attend_status','P')
                        ->where('shift_id','=','2')
                        ->with('professional')
                        ->orderBy('shift_id')
                        ->get();
    
                    $departments = $data->unique('department_id');
    
                    $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->where('attend_status','p')
                        ->where('shift_id','=','2')
                        ->with('professional')
                        ->selectRaw('department_id, count(employee_id) as emp_count')
                        ->groupBy('department_id')
                        ->get();
    
                    break;
                case 'Morning':

                    $data = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->where('attend_status','P')
                        ->whereIn('shift_id',[3,6,7,10,13,17,22,23,24,25,28,33,35,36,38])
                        ->with('professional')
                        ->orderBy('shift_id')
                        ->get();
    
                    $departments = $data->unique('department_id');
    
                    $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->where('attend_status','p')
                        ->whereIn('shift_id',[3,6,7,10,13,17,22,23,24,25,28,33,35,36,38])
                        ->with('professional')
                        ->selectRaw('department_id, count(employee_id) as emp_count')
                        ->groupBy('department_id')
                        ->get();
    
                    break;
                   
                    case 'Evening':
    
                        $data = DailyAttendance::query()->where('company_id',$this->company_id)
                            ->where('attend_date',$report_date)
                            ->where('attend_status','P')
                            ->whereIn('shift_id',[4,8,12,14,15,21,27,30,31])
                            ->with('professional')
                            ->orderBy('shift_id')
                            ->get();
        
                        $departments = $data->unique('department_id');
        
                        $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                            ->where('attend_date',$report_date)
                            ->where('attend_status','p')
                            ->whereIn('shift_id',[4,8,12,14,15,21,27,30,31])
                            ->with('professional')
                            ->selectRaw('department_id, count(employee_id) as emp_count')
                            ->groupBy('department_id')
                            ->get();
        
                        break;
                        
                        case 'Night':
    
                            $data = DailyAttendance::query()->where('company_id',$this->company_id)
                                ->where('attend_date',$report_date)
                                ->where('attend_status','P')
                                ->whereIn('shift_id',[5,9,11,16,26,29,32,34,37])
                                ->with('professional')
                                ->orderBy('shift_id')
                                ->get();
            
                            $departments = $data->unique('department_id');
            
                            $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                                ->where('attend_date',$report_date)
                                ->where('attend_status','p')
                                ->whereIn('shift_id',[5,9,11,16,26,29,32,34,37])
                                ->with('professional')
                                ->selectRaw('department_id, count(employee_id) as emp_count')
                                ->groupBy('department_id')
                                ->get();
            
                            break;
                      
            case 'leave':

                $data = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)->where('leave_flag',true)
                    ->where('attend_status','A')
                    ->with('professional')
                    ->orderBy('shift_id')
                    ->get();

                $departments = $data->unique('department_id');

                $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)->where('leave_flag',true)
                    ->where('attend_status','A')
                    ->with('professional')
                    ->selectRaw('department_id, count(employee_id) as emp_count')
                    ->groupBy('department_id')
                    ->get();

                break;


            case 'absent':

                $data = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)->where('leave_flag',false)
                    ->where('attend_status','A')->where('holiday_flag',false)
                    
                    ->where('shift_id','<>','1')
                    ->with('professional')
                    ->orderBy('shift_id')
                    ->get();

                $departments = $data->unique('department_id');

                $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)->where('leave_flag',false)
                    ->where('attend_status','A')->where('holiday_flag',false)
                    
                    ->where('shift_id','<>','1')
                    ->with('professional')
                    ->selectRaw('department_id, count(employee_id) as emp_count')
                    ->groupBy('department_id')
                    ->get();

                break;

            case 'offday':

                $data = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)
                    ->where('attend_status','A')
                    ->where('shift_id','=','1')
                    ->where('leave_flag',false)
                    ->with('professional')
                    ->get();

                $departments = $data->unique('department_id');

                $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',$report_date)
                    ->where('attend_status','A')
                    ->where('shift_id','=','1')
                    ->where('leave_flag',false)
                    ->with('professional')
                    ->selectRaw('department_id, count(employee_id) as emp_count')
                    ->groupBy('department_id')
                    ->get();

                break;

  case 'nightAbsent':

                    $data = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->where('attend_status','A')
                        ->whereIn('shift_id',[5,9,11,16,26,29,32,34,37])
                        
                        ->with('professional')
                        ->get();
    
                    $departments = $data->unique('department_id');
    
                    $groups = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->where('attend_status','A')
                        ->whereIn('shift_id',[5,9,11,16,26,29,32,34,37])
                        
                        ->with('professional')
                        ->selectRaw('department_id, count(employee_id) as emp_count')
                        ->groupBy('department_id')
                        ->get();
    
                    break;




            default:

                dd($status);

        }

        $view = \View::make('attendance.report.pdf.pdf-date-wise-status-employee',compact('data','departments','report_date','status','groups'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        ini_set('max_execution_time', 400);
        ini_set('memory_limit', '1024M');
        ini_set("output_buffering", 10240);
        ini_set('max_input_time',300);
        ini_set('default_socket_timeout',300);
        ini_set('pdo_mysql.cache_size',4000);
        ini_set('pcre.backtrack_limit', 5000000);


        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('attendance.pdf');

        return view('attendance.report.pdf.pdf-date-wise-status-employee');

//
    }

    public function statusNotAttendent(Request $request)
    {
        $report_date = Carbon::createFromFormat('d-m-Y',$request['absent_date'])->format('Y-m-d');

        $data = DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('attend_date',$report_date)
                        ->get();

       // dd($data);
        
        if($request['status_id'] == 1)
        {

            $inform_absent= DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('holiday_flag',false)
            ->where('inform_absent',true)
            ->where('leave_flag',false)
            ->where('shift_id','<>','1')
            ->with('professional')
            ->with('informAbsent')
            ->orderBy('shift_id')
            ->get();

            $absent = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('holiday_flag',false)
            ->where('inform_absent',false)           
            ->where('leave_flag',false)
            ->where('shift_id','<>','1')
            ->with('professional')
            ->orderBy('shift_id')
            ->get();

            $leave = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('leave_flag',true)
            ->whereIn('leave_id',[1,2,3,4,7,8,9,10])
            ->where('shift_id','<>','1')
            ->with('professional')
            ->with('leave')
            ->orderBy('shift_id')
            ->get();

            $Mleave = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('leave_flag',true)
            ->where('leave_id',5)
            ->where('shift_id','<>','1')
            ->with('professional')
            ->with('leave')
            ->orderBy('shift_id')
            ->get();

            $Qleave = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('leave_flag',true)
            ->where('leave_id',6)
            ->where('shift_id','<>','1')
            ->with('professional')
            ->with('leave')
            ->orderBy('shift_id')
            ->get();


            $resigned = EmpProfessional::query()
            ->where('company_id',$this->company_id)
            ->where('working_status_id','=','4')
            ->where('status_change_date',$report_date)
            ->get();

            $suspend = EmpProfessional::query()
            ->where('company_id',$this->company_id)
            ->where('working_status_id','=','3')
            ->where('status_change_date',$report_date)
            ->get();

            //dd($data);

        // $departments = $data->unique('department_id');

        $view = \View::make('attendance.report.pdf.pdf-date-wise-absent-status-all-employee',compact('inform_absent','absent','leave','Mleave','Qleave','resigned','suspend','report_date','status','data'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        ini_set('max_execution_time', 400);
        ini_set('memory_limit', '1024M');
        ini_set("output_buffering", 10240);
        ini_set('max_input_time',300);
        ini_set('default_socket_timeout',300);
        ini_set('pdo_mysql.cache_size',4000);
        ini_set('pcre.backtrack_limit', 5000000);


        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('attendance.pdf');

        return view('attendance.report.pdf.pdf-date-wise-absent-status-all-employee');

        $status = $request['status_id'];
        }
        
        if($request['status_id'] == 2)
        {

            $data = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('holiday_flag',false)
            ->where('inform_absent',true)
            ->where('leave_flag',false)
            ->where('shift_id','<>','1')
            ->with('professional')
            ->orderBy('shift_id')
            ->get();

            //dd($data);

        $departments = $data->unique('department_id');

        $status = $request['status_id'];
        }
        elseif($request['status_id'] == 3)
        {

            $data = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('holiday_flag',false)
            ->where('inform_absent',false)           
            ->where('leave_flag',false)

            ->where('shift_id','<>','1')
            ->with('professional')
            ->orderBy('shift_id')
            ->get();

            //dd($data);

        $departments = $data->unique('department_id');

        $status = $request['status_id'];
        }
        elseif($request['status_id'] == 4)
        {

            $data = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('leave_flag',true)
            ->whereIn('leave_id',[1,2,3,4,7,8,9,10])
            ->where('shift_id','<>','1')
            ->with('professional')
            ->orderBy('shift_id')
            ->get();

            //dd($data);

        $departments = $data->unique('department_id');

        $status = $request['status_id'];
        }
        elseif($request['status_id'] ==5)
        {

            $employees = EmpProfessional::query()
            ->where('company_id',$this->company_id)
            ->where('working_status_id','=','4')
            ->where('status_change_date',$report_date)
           
            ->get();

           // dd($data);

        $departments = $employees->unique('department_id');

        $status = $request['status_id'];
        }
        elseif($request['status_id'] ==6)
        {

            $employees = EmpProfessional::query()
            ->where('company_id',$this->company_id)
            ->where('working_status_id','=','3')
            ->where('status_change_date',$report_date)
            ->get();

           // dd($data);

        $departments = $employees->unique('department_id');

        $status = $request['status_id'];
        }
        elseif($request['status_id'] ==7)
        {

            $employees = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('leave_flag',true)
            ->where('leave_id',5)
            ->where('shift_id','<>','1')
            ->with('professional')
            ->with('leave')
            ->orderBy('shift_id')
            ->get();
            $departments = $employees->unique('department_id');

        $status = $request['status_id'];
        }
        elseif($request['status_id'] ==8)
        {

            $employees = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',$report_date)
            ->where('attend_status','A')
            ->where('leave_flag',true)
            ->where('leave_id',6)
            ->where('shift_id','<>','1')
            ->with('professional')
            ->with('leave')
            ->orderBy('shift_id')
            ->get();

           // dd($data);

        $departments = $employees->unique('department_id');

        $status = $request['status_id'];
        }
        $view = \View::make('attendance.report.pdf.pdf-date-wise-absent-status-employee',compact('data','departments','report_date','status','groups','employees'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        ini_set('max_execution_time', 400);
        ini_set('memory_limit', '1024M');
        ini_set("output_buffering", 10240);
        ini_set('max_input_time',300);
        ini_set('default_socket_timeout',300);
        ini_set('pdo_mysql.cache_size',4000);
        ini_set('pcre.backtrack_limit', 5000000);


        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('attendance.pdf');

        return view('attendance.report.pdf.pdf-date-wise-absent-status-all-employee');

            $status = $request['status_id'];
     
    }
}
