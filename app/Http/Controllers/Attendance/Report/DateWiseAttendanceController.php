<?php

namespace App\Http\Controllers\Attendance\Report;

use App\Exports\ShiftAllEmployeeAttendance;
use App\Exports\ShiftEmployeeAttendance;
use App\Models\Attendance\DailyAttendance;
use App\Models\Common\Department;
use App\Models\Attendance\PunchDetail;
use App\Models\Employee\EmpProfessional;
use App\Models\Roster\Shift;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DateWiseAttendanceController extends Controller
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

        if(check_privilege(38,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');


        if(!empty($request['action']))
        {
            $report_date = Carbon::createFromFormat('d-m-Y',$request['report_date'])->format('Y-m-d');

            switch ($request['action'])
            {
                case 'preview':

                    if($request->filled('employee_id'))
                    {
                        $data = DailyAttendance::query()
                            ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                                'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                                'leave_flag','offday_flag','shift_id','overtime_hour',
                                DB::raw('case when attend_status = "P" then "Present"
                                            when offday_flag = true and attend_status = "A" then "OffDay"
                                            when leave_flag = true and attend_status = "A" then "InLeave"
                                            when holiday_flag = true and attend_status = "A" then "Holiday"
                                            when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then "Absent" else "Noth" end as Status') )
                            ->where('attend_date',$report_date)
                            ->where('employee_id',$request['employee_id'])
                            ->with('professional')
                            ->first();

                        $punchs = PunchDetail::query()->where('employee_id',$request['employee_id'])
                            ->whereDate('attendance_datetime',$report_date)->get();


                        return view('attendance.report.employee-punch-details',compact('data','punchs'));
                    }else{
                        $data = DailyAttendance::query()
                        ->where('attend_date',$report_date)
                        ->select('attend_date','department_id', DB::Raw('count(employee_id) as emp_count'),
                            DB::raw('sum(case when attend_status = "P" then 1 else 0 end) as present'),
                            DB::raw('sum(case when offday_flag = true and attend_status = "A" then 1 else 0 end) as offday'),
                            DB::raw('sum(case when leave_flag = true and attend_status = "A" then 1 else 0 end) as n_leave'),
                            DB::raw('sum(case when holiday_flag = true and attend_status = "A" then 1 else 0 end) as holiday'),
                            DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                            )
                        ->groupBy('attend_date','department_id')
                        ->with('department')
                        ->get();

                    return view('attendance.report.date-wise-attendance-report-index',compact('data','departments'));
                    }

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



        return view('attendance.report.date-wise-attendance-report-index',compact('departments'));
    }

    public function departmentDailyReport(Request $request)
    {

        if(check_privilege(38,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');


        if(!empty($request['action']))
        {
            $report_date = Carbon::createFromFormat('d-m-Y',$request['report_date2'])->format('Y-m-d');

            libxml_use_internal_errors(true);

            switch ($request['action'])
            {
                case 'preview':

                    if($request->filled('department_id'))
                    {
                       if($request['status_id'] == 1)
                       {
                         $data = DailyAttendance::query()
                                ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                                    'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                                    'leave_flag','offday_flag','shift_id','overtime_hour',
                                    DB::raw('case when attend_status = "P" and offday_flag = false then "Present"
                                    when offday_flag = true then "OffDay"
                                    when leave_flag = true then "InLeave"
                                    when holiday_flag = true then "HloiDay"
                                    when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then "Absent" else "Noth" end as Status'))
                                ->where('attend_date',$report_date)
                                ->where('department_id',$request['department_id'])
                                ->with('professional')
                                ->get();

                        $view = \View::make('attendance.report.pdf.datewise-department-attendanceDetails',compact('data'));
                       }
                       if($request['status_id'] == 2)
                       {
                         $data = DailyAttendance::query()
                                ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                                    'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                                    'leave_flag','offday_flag','shift_id','overtime_hour',
                                    DB::raw('case when attend_status = "P" and offday_flag = false then "Present" end as Status'))
                                ->where('attend_date',$report_date)
                                ->where('attend_status','P')
                                ->where('department_id',$request['department_id'])
                                ->with('professional')
                                ->get();

                           // dd($data);

                        $view = \View::make('attendance.report.pdf.datewise-department-attendance',compact('data'));
                       }
                       if($request['status_id'] == 3)
                       {
                         $data = DailyAttendance::query()
                                ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                                    'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                                    'leave_flag','offday_flag','shift_id','overtime_hour',
                                    DB::raw('case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then "Absent" end as Status'))
                                ->where('attend_date',$report_date)
                                ->where('department_id',$request['department_id'])
                                ->with('professional')
                                ->get();

                        $view = \View::make('attendance.report.pdf.datewise-department-attendanceStatus',compact('data'));
                       }
                       if($request['status_id'] == 4)
                       {
                         $data = DailyAttendance::query()
                                ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                                    'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                                    'leave_flag','offday_flag','shift_id','overtime_hour',
                                    DB::raw('case when offday_flag = true then "OffDay" end as Status'))
                                ->where('attend_date',$report_date)
                                ->where('department_id',$request['department_id'])
                                ->with('professional')
                                ->get();

                        $view = \View::make('attendance.report.pdf.datewise-department-attendanceStatus',compact('data'));
                       }
                       if($request['status_id'] == 5)
                       {
                         $data = DailyAttendance::query()
                                ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                                    'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                                    'leave_flag','offday_flag','shift_id','overtime_hour',
                                    DB::raw('case when leave_flag = true then "InLeave" end as Status'))
                                ->where('attend_date',$report_date)
                                ->where('department_id',$request['department_id'])
                                ->with('professional')
                                ->get();

                        $view = \View::make('attendance.report.pdf.datewise-department-attendanceStatus',compact('data'));
                       }


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
                
                        $pdf::AddPage('L');
                
                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('dateWise-department-Report.pdf');

                    }else{
                        $data = DailyAttendance::query()
                        ->where('attend_date',$report_date)
                        ->select('attend_date','department_id', DB::Raw('count(employee_id) as emp_count'),
                            DB::raw('sum(case when attend_status = "P" then 1 else 0 end) as present'),
                            DB::raw('sum(case when offday_flag = true and attend_status = "A" then 1 else 0 end) as offday'),
                            DB::raw('sum(case when leave_flag = true and attend_status = "A" then 1 else 0 end) as n_leave'),
                            DB::raw('sum(case when holiday_flag = true and attend_status = "A" then 1 else 0 end) as holiday'),
                            DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                            )
                        ->groupBy('attend_date','department_id')
                        ->with('department')
                        ->get();

                    

                        $view = \View::make('attendance.report.pdf.datewise-department-attendanceAll',compact('data','departments'));
                        $html = $view->render();

                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(216,355), true, 'UTF-8', false);

                        $pdf::SetMargins(20, 5, 5,0);

                        $pdf::AddPage('L');

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('attendance.pdf');
                    }


                break;

            }
        }



        return view('attendance.report.date-wise-attendance-report-index',compact('departments'));
    }

    public function departmentDetailsReport($id,$date)
    {
        $data = DailyAttendance::query()
            ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                'leave_flag','offday_flag','shift_id','overtime_hour',
                DB::raw('case when attend_status = "P" and offday_flag = false then "Present"
                                            when offday_flag = true then "OffDay"
                                            when leave_flag = true then "InLeave"
                                            when holiday_flag = true then "HloiDay"
                                            when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then "Absent" else "Noth" end as Status') )
            ->where('attend_date',$date)
            ->where('department_id',$id)
            ->with('professional')
            ->get();


        return view('attendance.report.date-wise-employee-attendance-status',compact('data'));
    }

    public function printdepartmentDetailsReport($id,$date)
    {
        $data = DailyAttendance::query()
            ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                'leave_flag','offday_flag','shift_id','overtime_hour',
                DB::raw('case when attend_status = "P" and offday_flag = false then "Present"
                                            when offday_flag = true then "OffDay"
                                            when leave_flag = true then "InLeave"
                                            when holiday_flag = true then "HloiDay"
                                            when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then "Absent" else "Noth" end as Status') )
            ->where('attend_date',$date)
            ->where('department_id',$id)
            ->with('professional')
            ->get();


            $view = \View::make('attendance.report.pdf.print-departmentDetailsReport',compact('data'));
            $html = $view->render();

            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(216,355), true, 'UTF-8', false);

            $pdf::SetMargins(20, 5, 5,0);

            $pdf::AddPage('L');

            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output('attendance.pdf');


        return view('attendance.report.pdf.print-departmentDetailsReport',compact('data'));
    }

    public function inLeaveReport(Request $request)
    {
        dd($request->all());

        if(!empty($request['action']))
        {
            $report_date = Carbon::createFromFormat('d-m-Y',$request['report_date'])->format('Y-m-d');

            switch ($request['action'])
            {


                case 'preview':

                    if($request->filled('employee_id'))
                    {
                        $data = DailyAttendance::query()
                            ->select('department_id','employee_id','attend_date','entry_date','shift_entry_time','entry_time',
                                'exit_date','exit_time','shift_exit_time','attend_status','night_duty','holiday_flag',
                                'leave_flag','offday_flag','shift_id','overtime_hour',
                                DB::raw('case when attend_status = "P" and offday_flag = false then "Present"
                                            when offday_flag = true then "OffDay"
                                            when leave_flag = true then "InLeave"
                                            when holiday_flag = true then "HloiDay"
                                            when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then "Absent" else "Noth" end as Status') )
                            ->where('attend_date',$report_date)
                            ->where('employee_id',$request['employee_id'])
                            ->with('professional')
                            ->first();

                        $punchs = PunchDetail::query()->where('employee_id',$request['employee_id'])
                            ->whereDate('attendance_datetime',$report_date)->get();


                        return view('attendance.report.employee-punch-details',compact('data','punchs'));
                    }


                    $data = DailyAttendance::query()
                        ->where('attend_date',$report_date)
                        ->select('attend_date','department_id', DB::Raw('count(employee_id) as emp_count'),
                            DB::raw('sum(case when attend_status = "P" and offday_flag = false then 1 else 0 end) as present'),
                            DB::raw('sum(case when offday_flag = true then 1 else 0 end) as offday'),
                            DB::raw('sum(case when leave_flag = true then 1 else 0 end) as n_leave'),
                            DB::raw('sum(case when holiday_flag = true then 1 else 0 end) as holiday'),
                            DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                        )
                        ->groupBy('attend_date','department_id')
                        ->with('department')
                        ->get();

                    return view('attendance.report.date-wise-attendance-report-index',compact('data'));

                    break;

                case 'print':

                    dd('print');



                    $view = \View::make('prescription.pdf-print-prescription',compact('prescription','patient'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
//                    $pdf = new TCPDF('L', PDF_UNIT, array(105,148), true, 'UTF-8', false);
//                    $pdf::setMargin(0,0,0);

                    $fontname = TCPDF_FONTS::addTTFfont('font/solaiman-lipi.ttf', 'TrueTypeUnicode', '', 32);
                    $pdf::SetFont($fontname, '', 14, '', false);

//        $fontname1 = TCPDF_FONTS::addTTFfont('font/solaiman-lipi.ttf', 'TrueTypeUnicode', '', 32);
//        $pdf::SetFont($fontname1, '', 8, '', false);



                    $pdf::SetMargins(10, 25, 5,0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('prescription.pdf');

                    return view('prescription.pdf-print-prescription');

                    break;

            }
        }



        return view('attendance.report.date-wise-attendance-report-index');
    }

    public function dateShiftReport(Request $request)
    {

        if(check_privilege(38,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');

        if(!empty($request['action']))
        {
            $report_date = Carbon::createFromFormat('d-m-Y',$request['report_date'])->format('Y-m-d');

            libxml_use_internal_errors(true);

            switch ($request['action'])
            {


                case 'summary':

                    
                    $data = DailyAttendance::query()
                        ->where('attend_date',$report_date)
                        ->select('attend_date','department_id','name', DB::Raw('count(employee_id) as emp_count'))
                        ->join('departments', 'daily_attendances.department_id', '=', 'departments.id')
                        ->groupBy('attend_date','department_id')
                        ->with('department')
                        ->orderBy('name')
                        ->get();

                    //dd($data);

                        $view = \View::make('attendance.report.pdf.departmentWise-emp-count-attendence-pdf', compact('data', 'report_date','departments'));
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
                        $pdf::Output('deptwiseAttendenceCountStatus.pdf');
        
                    return view('attendance.report.date-wise-attendance-report-index',compact('data'));

                break;

                case 'print':

                    if($request->filled('department_id'))
                    {
                        $data = DailyAttendance::query()
                            ->where('daily_attendances.company_id',$this->company_id)
                            ->where('daily_attendances.department_id',$request['department_id'])
                            ->where('attend_date',$report_date)
                            ->with('department')
                            ->join('shifts', 'shifts.id', '=', 'daily_attendances.shift_id')
                            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'daily_attendances.employee_id')
                            ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                            ->join('duty_locations', 'duty_locations.id', '=', 'daily_attendances.location_id')
                            ->orderBy('shifts.Serial', 'asc')
                            ->orderBy('designations.SerialDsg', 'asc')
                           //->orderBy('department_id', 'asc')
                            ->get();
                        $employees = $data->unique('employee_id');
                        $department_id=$request['department_id'];
                        $department = Department::query()->where('company_id',$this->company_id)
                        ->where('status',true)->where('id',$department_id)->get();
                        $shifts = $data->unique('shift_id');

                        $view = \View::make('attendance.report.pdf.shift-wise-employee-attendance', compact('data', 'report_date', 'shifts','employees','department'));
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
                        $pdf::Output('deptAttendenceStatus.pdf');
        
                        }
                        else{       
        
                            $data = DailyAttendance::query()
                            ->where('daily_attendances.company_id',$this->company_id)
                            ->where('attend_date',$report_date)
                            ->where('daily_attendances.department_id','!=',1)
                            ->with('department')
                            ->join('shifts', 'shifts.id', '=', 'daily_attendances.shift_id')
                            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'daily_attendances.employee_id')
                            ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                            ->join('duty_locations', 'duty_locations.id', '=', 'daily_attendances.location_id')
                            ->orderBy('daily_attendances.department_id', 'asc')
                            ->orderBy('shifts.Serial', 'asc')
                            ->orderBy('designations.SerialDsg', 'asc')                            
                            ->get();
                            $departments = $data->unique('department_id');
                            $employees = $data->unique('employee_id');
                            $shifts = $data->unique('shift_id');

                           // dd($departments);
                        
                        $view = \View::make('attendance.report.pdf.shift-wise-all-employee-attendence', compact('data', 'report_date', 'shifts','employees','department','departments','data1'));
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
                        $pdf::Output('AllDeptAttendence.pdf');
                       
                    }                          

                    return view('attendance.report.shift-wise-Employee-attendance-report',compact('shifts','departments'));

                break;

                case 'download':

                if($request->filled('department_id'))
                    {
                        $data = DailyAttendance::query()
                            ->where('daily_attendances.company_id',$this->company_id)
                            ->where('daily_attendances.department_id',$request['department_id'])
                            ->where('attend_date',$report_date)
                            ->with('department')
                            ->join('shifts', 'shifts.id', '=', 'daily_attendances.shift_id')
                            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'daily_attendances.employee_id')
                            ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                            ->join('duty_locations', 'duty_locations.id', '=', 'daily_attendances.location_id')
                            ->orderBy('shifts.Serial', 'asc')
                            ->orderBy('designations.SerialDsg', 'asc')
                           //->orderBy('department_id', 'asc')
                            ->get();
                        $employees = $data->unique('employee_id');
                        $department_id=$request['department_id'];
                        $department = Department::query()->where('company_id',$this->company_id)
                        ->where('status',true)->where('id',$department_id)->get();
                        $shifts = $data->unique('shift_id');

                        return Excel::download(new ShiftEmployeeAttendance($data, $report_date, $shifts, $employees , $department ), 'ShiftWiseEmployee.xlsx');
        
                        }
                        else{       
        
                            $data = DailyAttendance::query()
                            ->where('daily_attendances.company_id',$this->company_id)
                            ->where('attend_date',$report_date)
                            ->where('daily_attendances.department_id','!=',1)
                            ->with('department')
                            ->join('shifts', 'shifts.id', '=', 'daily_attendances.shift_id')
                            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'daily_attendances.employee_id')
                            ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                            ->join('duty_locations', 'duty_locations.id', '=', 'daily_attendances.location_id')
                            ->orderBy('daily_attendances.department_id', 'asc')
                            ->orderBy('shifts.Serial', 'asc')
                            ->orderBy('designations.SerialDsg', 'asc')                            
                            ->get();
                            $departments = $data->unique('department_id');
                            $employees = $data->unique('employee_id');
                            $shifts = $data->unique('shift_id');

                           // dd($departments);
                        
                       return Excel::download(new ShiftAllEmployeeAttendance($data, $report_date, $shifts, $employees , $departments), 'ShiftWiseAllEmployee.xlsx');
                       
                    } 

                    break;

            }             

        }

        return view('attendance.report.shift-wise-Employee-attendance-report',compact('departments'));
    }

    public function dateShiftPunchReport(Request $request)
    {

        if(check_privilege(38,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');

        if(!empty($request['action']))
        {
            $report_date = Carbon::createFromFormat('d-m-Y',$request['report_date2'])->format('Y-m-d');

            libxml_use_internal_errors(true);

            switch ($request['action'])
            {

                case 'print':

                    if($request->filled('department_id'))
                    {
                        $data = DailyAttendance::query()
                            ->where('daily_attendances.company_id',$this->company_id)
                            ->where('daily_attendances.department_id',$request['department_id'])
                            ->where('attend_date',$report_date)
                            ->with('department')
                            ->join('shifts', 'shifts.id', '=', 'daily_attendances.shift_id')
                            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'daily_attendances.employee_id')
                            ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                            ->join('duty_locations', 'duty_locations.id', '=', 'daily_attendances.location_id')
                            ->orderBy('shifts.Serial', 'asc')
                            ->orderBy('designations.SerialDsg', 'asc')
                           //->orderBy('department_id', 'asc')
                            ->get();
                        $employees = $data->unique('employee_id');
                        $department_id=$request['department_id'];
                        $department = Department::query()->where('company_id',$this->company_id)
                        ->where('status',true)->where('id',$department_id)->get();
                        $shifts = $data->unique('shift_id');

                        $view = \View::make('attendance.report.pdf.shift-wise-employee-punch', compact('data', 'report_date', 'shifts','employees','department'));
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
                        $pdf::Output('deptAttendenceStatus.pdf');
        
                        }
                        else{       
        
                            $data = DailyAttendance::query()
                            ->where('daily_attendances.company_id',$this->company_id)
                            ->where('attend_date',$report_date)
                            ->where('daily_attendances.department_id','!=',1)
                            ->with('department')
                            ->join('shifts', 'shifts.id', '=', 'daily_attendances.shift_id')
                            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'daily_attendances.employee_id')
                            ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                            ->join('duty_locations', 'duty_locations.id', '=', 'daily_attendances.location_id')
                            ->orderBy('daily_attendances.department_id', 'asc')
                            ->orderBy('shifts.Serial', 'asc')
                            ->orderBy('designations.SerialDsg', 'asc')                            
                            ->get();
                            $departments = $data->unique('department_id');
                            $employees = $data->unique('employee_id');
                            $shifts = $data->unique('shift_id');

                           // dd($departments);
                        
                        $view = \View::make('attendance.report.pdf.shift-wise-all-employee-punch', compact('data', 'report_date', 'shifts','employees','department','departments','data1'));
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
                        $pdf::Output('AllDeptAttendence.pdf');
                       
                    }                          

                    return view('attendance.report.shift-wise-Employee-attendance-report',compact('shifts','departments'));

                break;

            }             

        }

        return view('attendance.report.shift-wise-Employee-attendance-report',compact('shifts','departments'));
    }

}
