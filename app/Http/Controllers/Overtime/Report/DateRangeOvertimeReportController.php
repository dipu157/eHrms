<?php

namespace App\Http\Controllers\Overtime\Report;

use App\Exports\OvertimeSetupExport;
use App\Models\Common\Department;
use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\PunchDetail;
use App\Models\Overtime\OvertimeSetup;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DateRangeOvertimeReportController extends Controller
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

        if (check_privilege(53, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id');


        if (!empty($request['action'])) {

            $from_date = Carbon::createFromFormat('d-m-Y', $request['from_date'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request['to_date'])->format('Y-m-d');
            $department_id = $request['department_id'];
            $dept_data = Department::query()->where('company_id', $this->company_id)->where('id', $request['department_id'])->first();

            $dates = createDateRange($from_date, getNextDay($to_date), 'Y-m-d');
            if ($department_id !== null) {
                $data = OvertimeSetup::query()
                ->where('company_id', $this->company_id)
                ->where('status', true)
                ->whereNull('finalize_by')
                ->whereBetween('ot_date', [$from_date, $to_date])
                ->with('professional')
                ->whereHas('professional', function ($query) use ($department_id) {
                    $query->where('department_id', $department_id);
                })
                ->with('approver')
                ->with('user')
                ->orderBy('ot_date', 'ASC')
                ->orderBy('employee_id', 'ASC')
                ->get();
            }
            else{
                $data = OvertimeSetup::query()
                ->where('company_id', $this->company_id)
                ->where('status', true)
                ->whereNull('finalize_by')
                ->whereBetween('ot_date', [$from_date, $to_date])
                ->with('professional')
                
                ->with('approver')
                ->with('user')
                ->orderBy('ot_date', 'ASC')
                ->orderBy('employee_id', 'ASC')
                ->get();
//dd($data);
            }
            

            libxml_use_internal_errors(true);

            switch ($request['action']) {

                case 'preview':

                    return view('overtime.report.date-range-overtime-index', compact('data', 'from_date', 'to_date', 'dept_data', 'departments', 'dates'));

                    break;

                case 'print':


                    $view = \View::make('overtime.report.print-date-range-overtime', compact('data', 'from_date', 'to_date', 'dept_data', 'departments', 'dates'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('overtime.pdf');

                    break;

                case 'excel':

                    return Excel::download(new OvertimeSetupExport($data, $from_date, $to_date, $dept_data, $dates, $departments), 'OvertimeExport.xls');
            }
        }

        return view('overtime.report.date-range-overtime-index', compact('departments'));
    }

    public function approveRejectOvertime(Request $request)
    {

        $departments = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id');


        if (!empty($request['action'])) {

            $from_date = Carbon::createFromFormat('d-m-Y', $request['from1_date'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request['to1_date'])->format('Y-m-d');
            $department_id = $request['department_id'];
            $dept_data = Department::query()->where('company_id', $this->company_id)->where('id', $request['department_id'])->first();

            $dates = createDateRange($from_date, getNextDay($to_date), 'Y-m-d');

            

            if ($department_id !== null) {
                switch ($request['action']) {
                    case 'print':

                        $attend = DailyAttendance::query()->where('company_id', $this->company_id)
                ->whereBetween('attend_date', [$from_date, $to_date])
                ->where('department_id', $department_id)->get();

                        if($request['status_id'] == 1)
                        {
                        $data = OvertimeSetup::query()
                            ->where('company_id', $this->company_id)
                            ->where('approval_status', true)
                            ->where('status', true)
                            ->whereNotNull('finalize_by')
                            ->whereBetween('ot_date', [$from_date, $to_date])
                            ->with('professional')
                            ->whereHas('professional', function ($query) use ($department_id) {
                                $query->where('department_id', $department_id);
                            })
                            ->with('approver')
                            ->with('user')
                            ->orderBy('ot_date', 'ASC')
                            ->get();

                        $newdata = collect();

                        foreach ($attend as $day) {
                            foreach ($data as $row) {
                                if (($row->ot_date == $day->attend_date) and ($row->employee_id == $day->employee_id)) {
                                    $row['entry'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->entry_date . ' ' . $day->entry_time)->format('d-m-Y g:i A') : Carbon::parse($day->entry_time)->format('g:i A');
                                    $row['exit'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->exit_date . ' ' . $day->exit_time)->format('d-m-Y g:i A') : Carbon::parse($day->exit_time)->format('g:i A');
                                    $row['shift_entry'] = $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_entry_time)->format('g:i A');
                                    $row['shift_exit'] =  $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_exit_time)->format('g:i A');

                                    //                        $row['calculated_hour'] = $row->overtime_from_punch;
                                    if ($row->overtime_from_punch == 0) {
                                        $from_ot_time = strtotime($day->attend_date . ' ' . $day->entry_time);
                                        $to_ot_time = strtotime($day->attend_date . ' ' . $day->shift_entry_time);

                                        $overtime_hour = floor(($to_ot_time - $from_ot_time) / 3600);

                                        $row['calculated_hour'] = $overtime_hour > 1 ? $overtime_hour : 0;
                                    } else {
                                        $row['calculated_hour'] = $row->overtime_from_punch;
                                    }


                                    $newdata->push($row);
                                }
                            }
                        }

                        $view = \View::make('overtime.report.print-date-range-overtime-ApproveList', compact('newdata', 'from_date', 'to_date', 'dept_data', 'departments', 'dates'));
                        $html = $view->render();
                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                        ini_set('max_execution_time', 900);
                        ini_set('memory_limit', '1024M');
                        ini_set("output_buffering", 10240);
                        ini_set('max_input_time', 300);
                        ini_set('default_socket_timeout', 300);
                        ini_set('pdo_mysql.cache_size', 4000);
                        ini_set('pcre.backtrack_limit', 10000000);


                        $pdf::reset();


                        $pdf::SetMargins(20, 5, 1, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DepartmentWise_overtime_approve.pdf');
                    }
              if($request['status_id'] == 2)
                        {
                      
                        $data = OvertimeSetup::query()
                            ->where('company_id', $this->company_id)
                            ->where('approval_status', true)
                            ->where('status', false)
                            ->whereNotNull('finalize_by')
                            ->whereBetween('ot_date', [$from_date, $to_date])
                            ->with('professional')
                            ->whereHas('professional', function ($query) use ($department_id) {
                                $query->where('department_id', $department_id);
                            })
                            ->with('approver')
                            ->with('user')
                            ->orderBy('ot_date', 'ASC')
                            ->get();

                        $newdata = collect();

                        foreach ($attend as $day) {
                            foreach ($data as $row) {
                                if (($row->ot_date == $day->attend_date) and ($row->employee_id == $day->employee_id)) {
                                    $row['entry'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->entry_date . ' ' . $day->entry_time)->format('d-m-Y g:i A') : Carbon::parse($day->entry_time)->format('g:i A');
                                    $row['exit'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->exit_date . ' ' . $day->exit_time)->format('d-m-Y g:i A') : Carbon::parse($day->exit_time)->format('g:i A');
                                    $row['shift_entry'] = $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_entry_time)->format('g:i A');
                                    $row['shift_exit'] =  $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_exit_time)->format('g:i A');


                                    if ($row->overtime_from_punch == 0) {
                                        $from_ot_time = strtotime($day->attend_date . ' ' . $day->entry_time);
                                        $to_ot_time = strtotime($day->attend_date . ' ' . $day->shift_entry_time);

                                        $overtime_hour = floor(($to_ot_time - $from_ot_time) / 3600);

                                        $row['calculated_hour'] = $overtime_hour > 1 ? $overtime_hour : 0;
                                    } else {
                                        $row['calculated_hour'] = $row->overtime_from_punch;
                                    }


                                    $newdata->push($row);
                                }
                            }
                        }

                        $view = \View::make('overtime.report.print-date-range-overtime-rejectList', compact('newdata', 'from_date', 'to_date', 'dept_data', 'departments', 'dates'));
                        $html = $view->render();

                        // $pdf = new TCPDF('L', PDF_UNIT, array(216,420), true, 'UTF-8', false);
                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                        ini_set('max_execution_time', 900);
                        ini_set('memory_limit', '1024M');
                        ini_set("output_buffering", 10240);
                        ini_set('max_input_time', 300);
                        ini_set('default_socket_timeout', 300);
                        ini_set('pdo_mysql.cache_size', 4000);
                        ini_set('pcre.backtrack_limit', 10000000);




                        $pdf::reset();


                        $pdf::SetMargins(20, 5, 1, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DepartmentWise_overtime_reject.pdf');
                    }
                        return view('overtime.report.date-range-overtime-index', compact('departments'));

                        break;
                }
            } 
            else {

                // dd($data1);

                switch ($request['action']) {

                    case 'summary':

                        $data1 = DB::table('overtime_setups')
                        ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'overtime_setups.employee_id')
                        ->join('departments', 'departments.id', '=', 'emp_professionals.department_id')
                        ->select('departments.name', DB::raw("SUM(overtime_setups.actual_overtime_hour) as overtime"))
                       ->where('overtime_setups.status', true)
                        ->whereNotNull('finalize_by')
                        ->whereBetween('ot_date', [$from_date, $to_date])
                        ->groupBy('departments.name')
                        ->orderBy('ot_date', 'ASC')
                        ->get();


                        $view = \View::make('overtime.report.date-range-overtime-department-summary', compact('data1', 'from_date', 'to_date','departments'));
                        $html = $view->render();
                        // $pdf = new TCPDF('L', PDF_UNIT, array(216,420), true, 'UTF-8', false);
                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                        ini_set('max_execution_time', 900);
                        ini_set('memory_limit', '1024M');
                        ini_set("output_buffering", 10240);
                        ini_set('max_input_time', 300);
                        ini_set('default_socket_timeout', 300);
                        ini_set('pdo_mysql.cache_size', 4000);
                        ini_set('pcre.backtrack_limit', 10000000);


                        $pdf::reset();


                        $pdf::SetMargins(20, 5, 1, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('Department_Summary_overtime_approve_hours.pdf');
                       
                        break;

    case 'print':
        $attend = DailyAttendance::query()->where('company_id', $this->company_id)
        ->whereBetween('attend_date', [$from_date, $to_date])->get();
      
        if($request['status_id'] == 1)
        {
        $data = OvertimeSetup::query()
            ->where('company_id', $this->company_id)
            ->where('approval_status', true)
            ->where('status', true)
            ->whereNotNull('finalize_by')
            ->whereBetween('ot_date', [$from_date, $to_date])
            ->with('professional')
    
            ->with('approver')
            ->with('user')
            ->orderBy('ot_date', 'ASC')
            ->get();

        $newdata = collect();

        foreach ($attend as $day) {
            foreach ($data as $row) {
                if (($row->ot_date == $day->attend_date) and ($row->employee_id == $day->employee_id)) {
                    $row['entry'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->entry_date . ' ' . $day->entry_time)->format('d-m-Y g:i A') : Carbon::parse($day->entry_time)->format('g:i A');
                    $row['exit'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->exit_date . ' ' . $day->exit_time)->format('d-m-Y g:i A') : Carbon::parse($day->exit_time)->format('g:i A');
                    $row['shift_entry'] = $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_entry_time)->format('g:i A');
                    $row['shift_exit'] =  $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_exit_time)->format('g:i A');

                    //                        $row['calculated_hour'] = $row->overtime_from_punch;
                    if ($row->overtime_from_punch == 0) {
                        $from_ot_time = strtotime($day->attend_date . ' ' . $day->entry_time);
                        $to_ot_time = strtotime($day->attend_date . ' ' . $day->shift_entry_time);

                        $overtime_hour = floor(($to_ot_time - $from_ot_time) / 3600);

                        $row['calculated_hour'] = $overtime_hour > 1 ? $overtime_hour : 0;
                    } else {
                        $row['calculated_hour'] = $row->overtime_from_punch;
                    }


                    $newdata->push($row);
                }
            }
        }
        //dd($newdata);
        $view = \View::make('overtime.report.print-date-range-overtime-ApproveList', compact('newdata', 'from_date', 'to_date', 'dept_data', 'departments', 'dates'));
        $html = $view->render();
        // $pdf = new TCPDF('L', PDF_UNIT, array(216,420), true, 'UTF-8', false);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '1024M');
        ini_set("output_buffering", 10240);
        ini_set('max_input_time', 300);
        ini_set('default_socket_timeout', 300);
        ini_set('pdo_mysql.cache_size', 4000);
        ini_set('pcre.backtrack_limit', 10000000);


        $pdf::reset();


        $pdf::SetMargins(20, 5, 1, 0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('All_Deparment_overtime_approve_list.pdf');
    }
if($request['status_id'] == 2)
        {
      
        $data = OvertimeSetup::query()
            ->where('company_id', $this->company_id)
            ->where('approval_status', true)
            ->where('status', false)
            ->whereNotNull('finalize_by')
            ->whereBetween('ot_date', [$from_date, $to_date])
            ->with('professional')
            
            ->with('approver')
            ->with('user')
            ->orderBy('ot_date', 'ASC')
            ->get();

        $newdata = collect();

        foreach ($attend as $day) {
            foreach ($data as $row) {
                if (($row->ot_date == $day->attend_date) and ($row->employee_id == $day->employee_id)) {
                    $row['entry'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->entry_date . ' ' . $day->entry_time)->format('d-m-Y g:i A') : Carbon::parse($day->entry_time)->format('g:i A');
                    $row['exit'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->exit_date . ' ' . $day->exit_time)->format('d-m-Y g:i A') : Carbon::parse($day->exit_time)->format('g:i A');
                    $row['shift_entry'] = $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_entry_time)->format('g:i A');
                    $row['shift_exit'] =  $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_exit_time)->format('g:i A');


                    if ($row->overtime_from_punch == 0) {
                        $from_ot_time = strtotime($day->attend_date . ' ' . $day->entry_time);
                        $to_ot_time = strtotime($day->attend_date . ' ' . $day->shift_entry_time);

                        $overtime_hour = floor(($to_ot_time - $from_ot_time) / 3600);

                        $row['calculated_hour'] = $overtime_hour > 1 ? $overtime_hour : 0;
                    } else {
                        $row['calculated_hour'] = $row->overtime_from_punch;
                    }


                    $newdata->push($row);
                }
            }
        }

        $view = \View::make('overtime.report.print-date-range-overtime-rejectList', compact('newdata', 'from_date', 'to_date', 'dept_data', 'departments', 'dates'));
        $html = $view->render();

        // $pdf = new TCPDF('L', PDF_UNIT, array(216,420), true, 'UTF-8', false);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '1024M');
        ini_set("output_buffering", 10240);
        ini_set('max_input_time', 300);
        ini_set('default_socket_timeout', 300);
        ini_set('pdo_mysql.cache_size', 4000);
        ini_set('pcre.backtrack_limit', 10000000);




        $pdf::reset();


        $pdf::SetMargins(20, 5, 1, 0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('All_Deparment_overtime_reject.pdf');
    }
break;
                    case 'excel':

                        return Excel::download(new OvertimeSetupExport($data1), 'OvertimeExport.xls');
                }
            }
        }

        return view('overtime.report.date-range-overtime-index', compact('departments'));
    }


public function empmonthlyovertime(Request $request)
    {

        if (check_privilege(745, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }  

        if (!empty($request['action'])) {


            $user_emp_id = Auth::user()->emp_id;
            $dept_id = Session::get('session_user_dept_id');
            $ext_dept = Department::query()->where('report_to',$user_emp_id)->first();
            $ext_dept_id = is_null($ext_dept) ? null : $ext_dept->id;
    
            
            $departments = Department::query()->whereId($dept_id)->first();
             //dd($departments);
            if($ext_dept_id!=null)
            {$Ex_departments = Department::query()->whereId($ext_dept_id)->first();}
////
            $from_date = Carbon::createFromFormat('d-m-Y', $request['from_date'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request['to_date'])->format('Y-m-d');
         
            $dates = createDateRange($from_date, getNextDay($to_date), 'Y-m-d');

            $employee_id = EmpProfessional::query()->where('emp_personals_id',$request['emp_id'])->pluck('employee_id');

//dd($employee_id);
        
//dd($data);
            switch ($request['action']) {

               
                case 'print':

                    if($request->filled('emp_id'))
                    {
                      $data = OvertimeSetup::query()
                          ->where('company_id', $this->company_id)
                          ->where('employee_id',$employee_id)
                          ->whereNotNull('finalize_by')
                          ->whereBetween('ot_date', [$from_date, $to_date])
                          ->with('professional')
                          ->with('approver')
                          ->with('user')
                          ->orderBy('ot_date', 'ASC')
                          ->get();
                         
          
                    }
                    else{
          
                      $data = OvertimeSetup::query()
                      ->where('company_id', $this->company_id)
                       ->whereHas('professional', function($q) use($dept_id,$ext_dept_id) {
                          $q->whereIn('department_id', [$dept_id,$ext_dept_id]);
                      })
                      ->whereNotNull('finalize_by')
                      ->whereBetween('ot_date', [$from_date, $to_date])
                      ->with('approver')
                      ->with('user')
                      ->orderBy('ot_date', 'ASC')
                      ->get();
                  
                  }
                
                    
                        $view = \View::make('overtime.report.print-employee-monthly-overtime', compact('data', 'from_date', 'to_date', 'dates','employee_id'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('overtimeEmployee.pdf');
                     
        
                    

                    break;

                    case 'OvertimePrint':

                        $data = DailyAttendance::query()->where('company_id',$this->company_id)
        ->where('employee_id',$employee_id)
        ->whereBetween('attend_date',[$from_date,$to_date])
        ->with('professional')
        ->with('leave')
        ->orderBy('attend_date','ASC')
        ->get();


        $Overtimedata = OvertimeSetup::query()
        ->where('company_id', $this->company_id)
        ->where('employee_id', $employee_id)
        ->where('approval_status',true)
        //->whereNotNull('finalize_by')
        ->whereBetween('ot_date', [$from_date, $to_date])
        ->get();

        //dd($Overtimedata);

        $punches = PunchDetail::query()
            ->select('id','employee_id',DB::raw('DATE_FORMAT(attendance_datetime, "%H:%i") as att_time'),
                'attendance_datetime')//->where('employee_id',2140186)
            ->where('employee_id',$employee_id)
            ->where('company_id',$this->company_id)
            ->whereBetween(DB::raw('DATE_FORMAT(attendance_datetime, "%Y-%m-%d")'),[$from_date,$to_date])
            ->get();

        $view = \View::make('overtime.report.print-pdf-date-range-emp-overtime-attendance', compact('data','Overtimedata','from_date','to_date','punches','employee_id'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(5, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('Attendance.pdf');
    break;
                }
        }

        return view('overtime.report.employee_monthly-overtime-index');
    }

}
