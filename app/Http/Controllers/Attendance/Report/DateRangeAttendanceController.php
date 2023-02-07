<?php

namespace App\Http\Controllers\Attendance\Report;

use App\Exports\AttendanceSummaryExport;
use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\PunchDetail;
use App\Models\Common\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Elibyy\TCPDF\Facades\TCPDF;
use Maatwebsite\Excel\Facades\Excel;

class DateRangeAttendanceController extends Controller
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

    public function index(Request $request)
    {

        if(check_privilege(39,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $dept_lists = Department::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name')->pluck('name','id');

        if(!empty($request['action']))
        {
            $from_date = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
            $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)->get();

            switch ($request['action'])
            {
                case 'preview':

                    if($request->filled('employee_id'))
                    {
                        $data = DailyAttendance::query()
                            ->where('company_id',$this->company_id)
                            ->where('employee_id',$request['employee_id'])
                            ->whereBetween('attend_date',[$from_date,$to_date])
                            ->select('department_id','employee_id',
                                DB::raw('sum(case when attend_status = "P" and offday_flag = false then 1 else 0 end) as present'),
                                DB::raw('sum(case when offday_flag = true then 1 else 0 end) as offday'),
                                DB::raw('sum(case when leave_flag = true then 1 else 0 end) as n_leave'),
                                DB::raw('sum(case when holiday_flag = true then 1 else 0 end) as holiday'),
                                DB::raw('sum(case when (late_flag = true) and (late_allow = false) then 1 else 0 end) as late_count'),
                                DB::raw('sum(overtime_hour) as overtime_hour'),
                                DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                            )
                            ->groupBy('department_id','employee_id')
                            ->orderBy('employee_id','ASC')
                            ->with('department')
                            ->get();
                    }else

                    if($request->filled('department_id'))
                    {
                        $data = DailyAttendance::query()
                            ->where('company_id',$this->company_id)
                            ->where('department_id',$request['department_id'])
                            ->whereBetween('attend_date',[$from_date,$to_date])
                            ->select('department_id','employee_id',
                                DB::raw('sum(case when attend_status = "P" and offday_flag = false then 1 else 0 end) as present'),
                                DB::raw('sum(case when offday_flag = true then 1 else 0 end) as offday'),
                                DB::raw('sum(case when leave_flag = true then 1 else 0 end) as n_leave'),
                                DB::raw('sum(case when holiday_flag = true then 1 else 0 end) as holiday'),
                                DB::raw('sum(case when (late_flag = true) and (late_allow = false) then 1 else 0 end) as late_count'),
                                DB::raw('sum(overtime_hour) as overtime_hour'),
                                DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                            )
                            ->groupBy('department_id','employee_id')
                            ->orderBy('employee_id','ASC')
                            ->with('department')
                            ->get();
                    }

                    return view('attendance.report.date-range-attendance-report',compact('data','from_date','to_date','departments','dept_lists'));

                    break;

                case 'print':

                    if($request->filled('department_id'))
                    {
                        $data = DailyAttendance::query()
                            ->where('company_id',$this->company_id)
                            ->where('department_id',$request['department_id'])
                            ->whereBetween('attend_date',[$from_date,$to_date])
                            ->select('department_id','employee_id',
                                DB::raw('sum(case when attend_status = "P" and offday_flag = false and holiday_flag = false and leave_flag=false then 1 else 0 end) as present'),
                                DB::raw('sum(case when offday_flag = true and leave_flag=false and holiday_flag=false then 1 else 0 end) as offday'),

                                DB::raw('sum(case when leave_id = 1 then 1 else 0 end) as casual'),
                                DB::raw('sum(case when leave_id = 4 then 1 else 0 end) as earn'),
                                DB::raw('sum(case when leave_id = 2 then 1 else 0 end) as sick'),
                                DB::raw('sum(case when leave_id = 3 then 1 else 0 end) as alterLeave'),
                                DB::raw('sum(case when leave_id = 5 then 1 else 0 end) as mlLeave'),
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
                    

                    $final = Collect();

                    foreach ($data as $row)
                    {

                        $row['total_lwp'] = $row->lateCount + $row->wpLeave + $row->absent;
                        $row['total_pdays'] = ($row->present + $row->offday + $row->holiday + $row->casual+ $row->earn + $row->sick + $row->alterLeave+ $row->spLeave + $row->QLeave) - ($row->lateCount);

                        $row['designation'] = $row->professional->designation->name;
                        $row['deg_order'] = $row->professional->designation->precedence;

                        $final->push($row);
                    }

                    $final = $final->sortBy('deg_order');

                    $view = \View::make('attendance.report.pdf.employee-attendance-summery', compact('final', 'from_date', 'to_date'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(216,355), true, 'UTF-8', false);

                    $pdf::SetMargins(10, 5, 5,0);

                    $pdf::AddPage('L');

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('AttendanceSummery.pdf');

                    break;

                }

                else{

                    $departments = Department::query()->where('company_id',$this->company_id)
                    ->where('status',true)
                    ->orderBy('id')->get();

                    $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                   
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->select('department_id','employee_id',
                        DB::raw('sum(case when attend_status = "P" and offday_flag = false and holiday_flag = false and leave_flag=false then 1 else 0 end) as present'),
                        DB::raw('sum(case when offday_flag = true and leave_flag=false and holiday_flag=false then 1 else 0 end) as offday'),

                        DB::raw('sum(case when leave_id = 1 then 1 else 0 end) as casual'),
                        DB::raw('sum(case when leave_id = 4 then 1 else 0 end) as earn'),
                        DB::raw('sum(case when leave_id = 2 then 1 else 0 end) as sick'),
                        DB::raw('sum(case when leave_id = 3 then 1 else 0 end) as alterLeave'),
                        DB::raw('sum(case when leave_id = 5 then 1 else 0 end) as mlLeave'),
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
            
                    //$departments = $data->unique('department_id');

            $final = Collect();

            foreach ($data as $row)
            {

                $row['total_lwp'] = $row->lateCount + $row->wpLeave + $row->absent;
                $row['total_pdays'] = ($row->present + $row->offday + $row->holiday + $row->casual+ $row->earn + $row->sick + $row->alterLeave+ $row->spLeave + $row->QLeave) - ($row->lateCount);

                $row['designation'] = $row->professional->designation->name;
                $row['deg_order'] = $row->professional->designation->precedence;

                $final->push($row);
            }
     
            $final = $final->sortBy('deg_order');
            //dd($data);
            $view = \View::make('attendance.report.pdf.employee-all-attendance-summery', compact('final','from_date','to_date','departments'));
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(216,355), true, 'UTF-8', false);

            ini_set('max_execution_time', 900);
            ini_set('memory_limit', '1024M');
            ini_set("output_buffering", 10240);
            ini_set('max_input_time', 300);
            ini_set('default_socket_timeout', 300);
            ini_set('pdo_mysql.cache_size', 4000);
            ini_set('pcre.backtrack_limit', 10000000);


            $pdf::reset();
            $pdf::SetMargins(10, 5, 5,0);

            $pdf::AddPage('L');

            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output('AttendanceSummery_All.pdf');

            break;  
                }

                case 'download':



                    if(is_null($request['department_id']))
                    {
                        return redirect()->back()->with('error','Please Select Department');
                    }

                    $data = DailyAttendance::query()
                        ->where('company_id',$this->company_id)
                        ->where('department_id',$request['department_id'])
                        ->whereBetween('attend_date',[$from_date,$to_date])
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

                            DB::raw('sum(case when leave_id = 5 then 1 else 0 end) as mlLeave'),

                            DB::raw('floor(sum(case when late_flag = true then 1 else 0 end)/3) as lateCount'),

                            DB::raw('sum(case when holiday_flag = true and leave_flag = false then 1 else 0 end) as holiday'),
                            DB::raw('sum(case when (late_flag = true) and (late_allow = false) then 1 else 0 end) as late_count'),
                            DB::raw('sum(overtime_hour) as overtime_hour'),


                            DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                        )
                        ->groupBy('department_id','employee_id')
                        ->orderBy('employee_id','ASC')
                        ->with('department')
                        ->get();

                    $final = Collect();

                    foreach ($data as $row)
                    {
                        $row['total_lwp'] = $row->lateCount + $row->wpLeave + $row->absent;
                        $row['total_pdays'] = ($row->present + $row->offday + $row->holiday + $row->casual+ $row->earn + $row->sick + $row->alterLeave + $row->spLeave + $row->QLeave)  - ($row->lateCount);
                        $row['department_name'] = preg_replace("/[^a-zA-Z 0-9]+/", "", $row->professional->department->name );
                        $row['designation_name'] = preg_replace("/[^a-zA-Z 0-9]+/", "", $row->professional->designation->name );
                        $final->push($row);
                    }




                    return Excel::download(new AttendanceSummaryExport($final,$from_date,$to_date), 'export.xls');

                    break;


            }
        }

        return view('attendance.report.date-range-attendance-report',compact('dept_lists'));
    }

    public function punchStatus(Request $request)
    {

        if(!empty($request['action']))
        {
            $from_date = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');

            $to_date = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
            switch ($request['action'])
            {


                case 'preview':

                    if($request->filled('employee_id'))
                    {



                        $punchs = PunchDetail::query()->where('employee_id',$request['employee_id'])
                            ->whereBetween('attendance_datetime',[$from_date,$to_date])
                            ->with('professional')->get();

                        return view('attendance.report.dateRange-employee-punch-details',compact('data','punchs','from_date','to_date'));
                    }




                    return view('attendance.report.date-wise-attendance-report-index',compact('data'));

                    break;

                case 'print':

                    dd('print');



                    $view = \View::make('prescription.pdf-print-prescription',compact('prescription','patient'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    $fontname = TCPDF_FONTS::addTTFfont('font/solaiman-lipi.ttf', 'TrueTypeUnicode', '', 32);
                    $pdf::SetFont($fontname, '', 14, '', false);


                    $pdf::SetMargins(10, 25, 5,0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('prescription.pdf');

                    return view('prescription.pdf-print-prescription');

                    break;

            }
        }



        return view('attendance.report.date-wise-attendance-report-index');




        $view = \View::make('attendance.report.pdf.pdf-date-range-status', compact('data', 'from_date', 'to_date','employees','status'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('AttendanceStatus.pdf');
    }

    public function employeeRange($id, $from, $to)
    {
        $data = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('employee_id',$id)
            ->whereBetween('attend_date',[$from,$to])
            ->with('professional')
            ->orderBy('attend_date','ASC')
            ->get();

        return view('attendance.report.date-range-employee-report',compact('data'));
    }

    public function printEmployeeRange($id, $from_date, $to_date)
    {
        $data = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('employee_id',$id)
            ->whereBetween('attend_date',[$from_date,$to_date])
            ->with('professional')
            ->with('leave')
            ->orderBy('attend_date','ASC')
            ->get();

        $view = \View::make('attendance.report.pdf.pdf-date-range-emp-attendance', compact('data', 'from_date', 'to_date'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('Attendance.pdf');


//        return view('attendance.report.pdf.pdf-date-range-emp-attendance',compact('data'));
    }

    public function departmentAttendece(Request $request)
    {
        if(check_privilege(744,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        if(!empty($request['action']))
        {
            $user_emp_id = Auth::user()->emp_id;
            $dept_id = Session::get('session_user_dept_id');
            $ext_dept = Department::query()->where('report_to',$user_emp_id)->first();
            $ext_dept_id = is_null($ext_dept) ? null : $ext_dept->id;
    
            $from_date = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
            $departments = Department::query()->whereId($dept_id)->first();
            if($ext_dept_id!=null)
            {$Ex_departments = Department::query()->whereId($ext_dept_id)->first();}
            

            switch ($request['action'])
            {
                case 'preview':

                            $data = DailyAttendance::query()
                                ->where('company_id',$this->company_id)
                                ->with('professional')
                                ->whereHas('professional', function($q) use($dept_id,$ext_dept_id) {
                                    $q->whereIn('department_id', [$dept_id,$ext_dept_id]);
                                })
                                  ->whereBetween('attend_date',[$from_date,$to_date])
                                ->select('department_id','employee_id',
                                    DB::raw('sum(case when attend_status = "P" and offday_flag = false then 1 else 0 end) as present'),
                                    DB::raw('sum(case when offday_flag = true then 1 else 0 end) as offday'),
                                    DB::raw('sum(case when leave_flag = true then 1 else 0 end) as n_leave'),
                                    DB::raw('sum(case when holiday_flag = true then 1 else 0 end) as holiday'),
                                    DB::raw('sum(case when (late_flag = true) and (late_allow = false) then 1 else 0 end) as late_count'),
                                    DB::raw('sum(overtime_hour) as overtime_hour'),
                                    DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                                )
                                
                                ->groupBy('department_id','employee_id')
                                ->orderBy('employee_id','ASC')
                                ->with('department')
                                ->get();


                    return view('attendance.report.date-range-departmentAttendence-report',compact('data','from_date','to_date','departments','Ex_departments'));

                    break;





            }
        }

        return view('attendance.report.date-range-departmentAttendence-report',compact('$departments','Ex_departments'));

    }

    public function statusPrint(Request $request)
    {
        $from_date = Carbon::createFromFormat('d-m-Y',$request['s_from_date'])->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d-m-Y',$request['s_to_date'])->format('Y-m-d');


        if($request['status_id'] == 1)
        {

            if($request->filled('employee_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('employee_id',$request['employee_id'])
                    ->where('late_flag',true)
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();
                    
                    $employees = $data->unique('employee_id');
                    $status = $request['status_id'];
                    $view = \View::make('attendance.report.pdf.pdf-date-range-employeewise-status', compact('data','from_date','to_date','employees','status','msg'));
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
                    $pdf::Output('EmployeeWise_Late_Status.pdf');
                    return view('attendance.report.pdf.pdf-date-range-employeewise-status');
            }
            else{

                $msg = "No Data Found!!";
            }

            if($request->filled('department_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('department_id',$request['department_id'])
                    ->where('late_flag',true)
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();

                $employees = $data->unique('employee_id');
               // dd($data);
            }
              else{

                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    
                    ->where('late_flag',true)
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();

                $employees = $data->unique('employee_id');
                $departments = $data->unique('department_id');

                $view = \View::make('attendance.report.pdf.pdf-date-range-late-emp', compact('data', 'from_date', 'to_date','employees','departments','status','msg'));
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
                $pdf::Output('LateStatus.pdf');
                        
                return view('attendance.report.pdf.pdf-date-range-late-emp');
            }
            $status = $request['status_id'];
        }


        if($request['status_id'] == 2)
        {

            if($request->filled('employee_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('employee_id',$request['employee_id'])
                    ->where('attend_status','A')
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->where('holiday_flag',false)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();
                    $employees = $data->unique('employee_id');
                    $status = $request['status_id'];
                    $view = \View::make('attendance.report.pdf.pdf-date-range-employeewise-status', compact('data','from_date','to_date','employees','status','msg'));
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
                    $pdf::Output('EmployeewiseAbsentStatus.pdf');
                    return view('attendance.report.pdf.pdf-date-range-employeewise-status');
             
            }else{

                $msg = "No Data Found!!";
            }

            if($request->filled('department_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('department_id',$request['department_id'])
                    ->where('attend_status','A')
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->where('holiday_flag',false)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();

                $employees = $data->unique('employee_id');
            }

            else{
                            $data = DailyAttendance::query()
                            ->where('company_id',$this->company_id)
                            ->where('attend_status','A')
                            ->where('leave_flag',false)
                            ->where('offday_flag',false)
                            ->where('holiday_flag',false)
                            ->whereBetween('attend_date',[$from_date,$to_date])
                            ->with('professional','shift','department')
                            ->orderBy('department_id')
                            ->orderBy('employee_id')
                            ->orderBy('attend_date')
                            ->get();
                            $employees = $data->unique('employee_id');
                                 $departments = $data->unique('department_id');

                            $view = \View::make('attendance.report.pdf.pdf-date-range-absent-emp', compact('data', 'from_date', 'to_date','employees','departments','status','msg'));
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
                            $pdf::Output('AbsentStatus.pdf');
                                    
                            return view('attendance.report.pdf.pdf-date-range-absent-emp');

            }
                $status = $request['status_id'];
        }


        if($request['status_id'] == 3)
        {

            if($request->filled('employee_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('employee_id',$request['employee_id'])
                    ->where('attend_status','A')
                    ->where('leave_flag',true)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();
                    $employees = $data->unique('employee_id');
                    $status = $request['status_id'];
                    $view = \View::make('attendance.report.pdf.pdf-date-range-employeewise-status', compact('data','from_date','to_date','employees','status','msg'));
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
                    $pdf::Output('Employee_wise_Leave_Status.pdf');
                    return view('attendance.report.pdf.pdf-date-range-employeewise-status');
            }else{

                $msg = "No Data Found!!";
            }

            if($request->filled('department_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('department_id',$request['department_id'])
                    ->where('attend_status','A')
                    ->where('leave_flag',true)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift','leave')
                    ->orderBy('attend_date')
                    ->get();

                $employees = $data->unique('employee_id');
            }
            else{
                $data = DailyAttendance::query()
                ->where('company_id',$this->company_id)
                ->where('attend_status','A')
                ->where('leave_flag',true)
                ->whereBetween('attend_date',[$from_date,$to_date])
                ->with('professional','shift')
                ->orderBy('department_id')
                ->orderBy('attend_date')
                ->get();
                        $employees = $data->unique('employee_id');
                         $departments = $data->unique('department_id');
               
                         $view = \View::make('attendance.report.pdf.pdf-date-range-leave-emp', compact('data', 'from_date', 'to_date','employees','departments','status','msg'));
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
                         $pdf::Output('leaveStatus.pdf');
                         
                         return view('attendance.report.pdf.pdf-date-range-leave-emp');
            

            }
            $status = $request['status_id'];
        }

        if($request['status_id'] == 4)
        {


            if($request->filled('employee_id'))
            {


                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('employee_id',$request['employee_id'])
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->where('attend_status','P')
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();

               // dd($data);
                    
                    $employees = $data->unique('employee_id');
                    $status = $request['status_id'];
                    $view = \View::make('attendance.report.pdf.pdf-date-range-employe-Exitstatus', compact('data','from_date','to_date','employees','status','msg'));
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
                    $pdf::Output('EmployeeWise_Late_Status.pdf');
                    return view('attendance.report.pdf.pdf-date-range-employe-Exitstatus');
            }
            else{

                $msg = "No Data Found!!";
            }

            if($request->filled('department_id'))
            {
                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('department_id',$request['department_id'])
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();

                $employees = $data->unique('employee_id');
                $departments = $data->unique('department_id');
               // dd($data);

                $view = \View::make('attendance.report.pdf.pdf-date-range-Exitstatus', compact('data', 'from_date', 'to_date','employees','departments','status','msg'));
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
                $pdf::Output('LateStatus.pdf');
            }
              else{

                $data = DailyAttendance::query()
                    ->where('company_id',$this->company_id)
                    ->where('leave_flag',false)
                    ->where('offday_flag',false)
                    ->whereBetween('attend_date',[$from_date,$to_date])
                    ->with('professional','shift')
                    ->orderBy('attend_date')
                    ->get();

                $employees = $data->unique('employee_id');
                $departments = $data->unique('department_id');

                $view = \View::make('attendance.report.pdf.pdf-date-range-exit-emp', compact('data', 'from_date', 'to_date','employees','departments','status','msg'));
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
                $pdf::Output('LateStatus.pdf');
                        
                return view('attendance.report.pdf.pdf-date-range-exit-emp');
            }
            $status = $request['status_id'];
        }
        
        $view = \View::make('attendance.report.pdf.pdf-date-range-status', compact('data','from_date','to_date','employees','status','msg'));
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
        $pdf::Output('AttendanceStatus.pdf');


    }

}
