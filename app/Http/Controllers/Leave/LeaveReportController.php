<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\LeaveDeptExport;
use App\Models\Common\Department;
use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\PublicHoliday;
use Elibyy\TCPDF\Facades\TCPDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveApplication;
use App\Models\Leaves\LeaveMaster;
use App\Models\Leaves\LeaveRegister;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LeaveReportController extends Controller
{
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
        if (check_privilege(28, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $dept_lists = Department::query()->where('company_id', $this->company_id)->where('status', true)
            ->orderBy('name')->pluck('name', 'id');

        return view('leave.report.daterange-leave-index', compact('dept_lists'));
    }

    public function empLeaveReport(Request $request)
    {
        if (check_privilege(28, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        
        if (!empty($request['action'])) {
            $from_date = Carbon::createFromFormat('d-m-Y', $request['from_date'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request['to_date'])->format('Y-m-d');

            switch ($request['action']) {
                case 'print':

                    if ($request->filled('emp_id')) {

                        $emp_leaves = LeaveMaster::query()->where('company_id',$this->company_id)->get();

                        $l_year = Carbon::createFromFormat('d-m-Y', $request['from_date'])->format('Y');


                        $emp_yearly_leave = LeaveRegister::query()
                                            ->where('emp_personals_id',$request['emp_id'])
                                            ->where('leave_year',$l_year)
                                            ->with('type')
                                            ->get();

                        $employe_id = EmpProfessional::query()->where('emp_personals_id',$request['emp_id'])->pluck('employee_id');


                        $employees = EmpProfessional::query()->where('company_id',$this->company_id)
                                    ->whereIn('working_status_id',[1,2,8])
                                    ->where('employee_id',$employe_id)
                                    ->with('personal')
                                    ->get();

                        $g_holidays = PublicHoliday::query()->where('company_id',$this->company_id)
                                      ->where('hYear',$l_year)
                                      ->pluck('from_date');

                        $g_holidays_day = PublicHoliday::query()->where('company_id',$this->company_id)
                                      ->where('hYear',$l_year)
                                      ->select(DB::raw("SUM(count) as gholidays"))
                                      ->pluck('gholidays');

                        $g_holidayCont = PublicHoliday::query()->where('company_id',$this->company_id)
                            ->where('hYear',$l_year)
                            ->pluck('count');

                        $g_holidaysday = PublicHoliday::query()->where('company_id',$this->company_id)
                            ->where('hYear',$l_year)
                            ->select(DB::raw("count(count) as gholidays"))
                            ->pluck('gholidays');


                        foreach ($employees as $emp) {
                            
                            $join_date = $emp->joining_date;
                            //$process_date = date('Y-m-d');

                            $join_date_str = strtotime($join_date);
                            $join_date_day = date("d", $join_date_str);
                            $join_month_days = Carbon::parse($join_date)->daysInMonth;
                            $join_month_work = $join_month_days - $join_date_day;

                            $w_months = nb_mois($join_date,$to_date);

                            $join_day=Carbon::parse($join_date);

                            $process_day=Carbon::parse($to_date);

                            $w_day=$join_day->diffInDays($process_day);

                            $count = 0;

                           // dd($g_holidays);


                            //dd($g_holidaysday[0]);

                            for ($i=0; $i<$g_holidaysday[0]; $i++) {

                                if($g_holidays[$i] > $join_date){

                                    break;
                                }
                                else
                                {
                                    $count += $g_holidayCont[$i];
                                }
                            }       

                            //dd($count);                  

                            $total_gdays = $g_holidays_day[0] - $count ;

                            if($w_months >= 12){

                                $total_wDays = 365;
                                $total_wHolidays = 52;
                                $total_gHolidays = $g_holidays_day[0];
                            }else{

                                $total_wDays = $w_day+1;
                                // $total_wHolidays = round($total_wDays/7);
                                $total_wHolidays = dayCount($join_date,$to_date,5);
                                $total_gHolidays = $total_gdays;
                            }
                    }

                        //dd($total_wDays);

                        $data = DailyAttendance::query()
                                ->where('company_id',$this->company_id)
                                ->whereBetween('attend_date',[$from_date,$to_date])
                                ->where('employee_id',$employe_id)
                                ->select('employee_id',

                                    DB::raw('sum(case when leave_id = 9 then 1 else 0 end) as wpLeave'),
                                    DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                                )
                                ->with('professional')
                                ->whereHas('professional',function($query){
                                    $query->whereIn('working_status_id',[1,2,8]);})        
                                ->get();

                           // dd($data);
                    }


                    $final = Collect();

                    foreach ($data as $row) {

                        $row['designation'] = $row->professional->designation->name;
                        $row['deg_order'] = $row->professional->designation->precedence;

                        $final->push($row);
                    }

                    $final = $final->sortBy('deg_order');

                $view = \View::make('leave.report.pdf.employee-leave-index-summery', compact('final','from_date', 'to_date','emp_yearly_leave','l_year','total_wDays','w_months','total_wHolidays','total_gHolidays'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(216, 355), true, 'UTF-8', false);

                    $pdf::SetMargins(10, 5, 5, 0);

                    $pdf::AddPage('P');

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('EmployeeLeaveSummery.pdf');

                    break;
            }
        }

        return view('leave.report.employee-leave-index');
    }

    public function leaveStatusPrint(Request $request)
    {
        $from_date = Carbon::createFromFormat('d-m-Y',$request['s_from_date'])->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d-m-Y',$request['s_to_date'])->format('Y-m-d');


        if($request['status_id'] == 3)
        {

            if($request->filled('department_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('department_id',$request['department_id'])
                    ->where('attend_status','A')
                    ->where('leave_flag',true)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift','leave')
                    //->whereHas('professional',function($query){
                        //$query->whereIn('working_status_id',[1,2,8]);})
                    ->orderBy('attend_date')
                    ->get();

                $employees = $data->unique('employee_id');
                $departments = $data->unique('department_id'); 
            }
            else{
                $data = DailyAttendance::query()
                ->where('company_id',$this->company_id)
               
                ->where('attend_status','A')
                ->where('leave_flag',true)
                ->whereBetween('attend_date',[$from_date,$to_date])
                ->with('professional','shift')
                ->whereHas('professional',function($query){
                    $query->whereIn('working_status_id',[1,2,8]);})
                ->orderBy('department_id')
                ->orderBy('employee_id')
                ->orderBy('attend_date')
                ->get();    

            $employees = $data->unique('employee_id');
            $departments = $data->unique('department_id');  

            }

            $status = $request['status_id'];
        }

        switch ($request['action']) {
            case 'print':

                $view = \View::make('attendance.report.pdf.pdf-date-range-leave-emp', compact('data','from_date','to_date','employees','departments','status','msg'));
                $html = $view->render();

                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                $pdf::SetMargins(20, 5, 5,0);

                $pdf::AddPage();

                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::Output('AttendanceStatus.pdf');                

            break;
            
            case 'download':

                libxml_use_internal_errors(true);

                return Excel::download(new LeaveDeptExport($data,$from_date,$to_date,$employees,$departments,$status), 'leavereportexport.xls');

            break;
        }

        
    }

public function leaveSummaryPrint(Request $request)
    {
        $from_date = Carbon::createFromFormat('d-m-Y',$request['t_from_date'])->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d-m-Y',$request['t_to_date'])->format('Y-m-d');
       

        switch ($request['action']) {
            
            case 'print':

                if($request->filled('department_id'))
            {
                $data = DailyAttendance::query()
                                ->where('company_id',$this->company_id)
                                ->whereBetween('attend_date',[$from_date,$to_date])
                               ->where('department_id',$request['department_id'])
                               ->where('leave_flag',true)
                                ->select('department_id','employee_id',

                                    DB::raw('sum(case when attend_status = "A" and leave_flag = true then 1 else 0 end) as totaleave')
                                )
                                ->groupBy('department_id','employee_id')
                                ->with('professional')
                                //->whereHas('professional',function($query){
                                  //  $query->whereIn('working_status_id',[1,2,8]);})        
                                ->get();

              $employees = $data->unique('employee_id');
                $departments = $data->unique('department_id'); 
                //dd($data);
                //dump($data);
            }
            else{
                $data = DailyAttendance::query()
                                    ->where('company_id',$this->company_id)
                                    ->whereBetween('attend_date',[$from_date,$to_date])
                                 
                                   ->where('leave_flag',true)
                                    ->select('department_id','employee_id',
    
                                        DB::raw('sum(case when attend_status = "A" and leave_flag = true then 1 else 0 end) as totaleave')
                                    )
                                    ->groupBy('department_id','employee_id')
                                    ->with('professional')
                                          
                                    ->get();
            }
$employees = $data->unique('employee_id');
$departments = $data->unique('department_id');  
libxml_use_internal_errors(true);           
$view = \View::make('leave.report.pdf.pdf-date-range-leave-deptsummary', compact('data','from_date','to_date','employees','departments','status','msg'));
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
                $pdf::Output('Leave_summary.pdf');                

            break;
            
            case 'alldept':

               



                $data1 = DailyAttendance::query()
                ->where('company_id',$this->company_id)
                ->whereBetween('attend_date',[$from_date,$to_date])
                ->where('attend_status','A')
                ->where('leave_flag',true)
              ->select('department_id', DB::Raw('count(employee_id) as emp_count')
                   
                    )
                ->groupBy('department_id')
                ->with('department')
                ->orderBy('department_id')
                ->get();

                $data = $data1->groupBy('department_id')->map(function ($row) {

                    $grouped = Collect();
                    $row->emp_count = $row->count('data1.emp_count');         
                  
                    
                    $grouped->push($row);
                
                    return $grouped;
                });
                
                //dd($data);
    
                 $employees = $data->unique('employee_id');
                    $departments = $data->unique('department_id'); 

                    //dd($data);
                    //dump($data);
           
                    libxml_use_internal_errors(true); 
                    $view = \View::make('leave.report.pdf.deptwise-emp-leave-summary', compact('data','from_date','to_date','employees','departments','status','msg'));
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
                    $pdf::Output('Leave_summary.pdf');                
           
                
                
            break;

           
                }


    }
}
