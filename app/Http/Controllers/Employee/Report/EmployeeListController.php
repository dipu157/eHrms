<?php

namespace App\Http\Controllers\Employee\Report;

use App\Exports\EmployeeExport;
use App\Exports\EmployeeHistoryExport;
use App\Exports\EmployeeDesigWiseExport;
use App\Exports\EmployeeSecWiseExport;

use App\Exports\EmployeeStatusExport;
use App\Exports\EmployeeDeptWiseExport;
use App\Models\Common\Department;
use App\Models\Common\Section;
use App\Models\Employee\Designation;
use App\Models\Employee\BaseDesignation;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpHistory;
use App\Models\Employee\EmpRecomended;
use App\Models\Common\WorkingStatus;
use App\Models\Employee\EmpProfessional;
use App\Models\Attendance\DailyAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\Punish;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeListController extends Controller
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

        $departments = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $Bdesignation = BaseDesignation::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $designations = Designation::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $wStatus = WorkingStatus::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('id')
            ->pluck('name', 'id');

        $empHistory = EmpHistory::query()->where('company_id', $this->company_id)
            ->with('department')
            ->with('designation')
            ->get();

        $empRecomend = EmpRecomended::query()->where('company_id', $this->company_id)
            ->with('department')
            ->with('designation')
            ->get();

        // dd($Bdesignation);

        if ($request->filled('search_id')) {

            $departments = Department::query()->where('company_id', $this->company_id)
                ->where('status', true)
                ->orderBy('name')->get();

            if ($request->filled('department_id')) {
                $employees = EmpProfessional::query()->whereIn('working_status_id', [1, 2, 3, 8])
                    ->where('department_id', $request['department_id'])
                    ->orderBy('designation_id')
                    ->get();

                $dept_name = Department::query()->where('company_id', $this->company_id)
                    ->where('status', true)->where('id', $request['department_id'])
                    ->pluck('name');

                // dd($dept_name);

                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id', $this->company_id)
                    ->whereIn('emp_professionals.working_status_id', [1, 2, 8])
                    ->where('department_id', $request['department_id'])
                    ->with('personal')
                    ->with('history')
                    ->with('recomended')
                    ->with('department')
                    ->with('designation')
                    ->with('salary_properties')
                    ->orderBy('emp_professionals.designation_id', 'ASC');
                
                $enddate = '2021-12-31';

                $employees = $employeesQuery->get();

                $employees2 = $employeesQuery->where('status',0)->get();

               // dd($employees2);

               // dd($employees1);
            } else {
                $employees = EmpProfessional::query()
                    ->whereIn('working_status_id', [1, 2, 3, 8])
                    ->get();

                    $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                    ->whereIn('working_status_id',[1,2,8])
                    ->with('personal')
                    ->with('history')
                    ->with('department')
                    ->with('recomended')
                    ->with('designation')
                    ->with('salary_properties')
                    ->orderBy('department_id','ASC');                      
    
                     $employees = $employeesQuery->get();

                    // dd($employees1);

                     $enddate = '2021-12-31';
    
                     $dept_name = null;
            }

            libxml_use_internal_errors(true);

            switch ($request['action']) {

                case 'export':

                   return Excel::download(new EmployeeExport($employees, $departments), 'allemployee.xlsx');
                    // return Excel::download(new EmployeeHistoryExport($employees1,$empHistory,$empRecomend,$designations,$departments,$dept_name,$enddate), 'employeeHistory.xlsx');
                    break;

                case    'Allhistory':

                    $view = \View::make('employee.report.print.pdf-employeeHistory-list', compact('employees','empHistory','empRecomend','designations','departments','dept_name','enddate'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 90000);
                    ini_set('memory_limit', '4096M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 20000000);

                    $pdf::SetMargins(5, 2, 2, 0);

                    $pdf::changeFormat(array(216, 420));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-2);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 6, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('designationWiseEmployee.pdf');

                    break;

                case    'print':

                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);


                    $view = \View::make('employee.report.print.pdf-employee-list', compact('employees', 'departments', 'dept_name'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    $pdf::SetMargins(20, 5, 5, 0);
                    $pdf::AddPage();
                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('employeeList.pdf');

                    break;

                    case    'history':

                        $view = \View::make('employee.report.print.pdf-BaseEmployeeHistory-list', compact('employees2','empHistory','empRecomend','designations','departments','dept_name','enddate'));
                        $html = $view->render();
    
                        $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);
    
                        //            set_time_limit(180);
                        ini_set('max_execution_time', 90000);
                        ini_set('memory_limit', '4096M');
                        ini_set("output_buffering", 10240);
                        ini_set('max_input_time', 300);
                        ini_set('default_socket_timeout', 300);
                        ini_set('pdo_mysql.cache_size', 4000);
                        ini_set('pcre.backtrack_limit', 20000000);
    
                        $pdf::SetMargins(5, 2, 2, 0);
    
                        $pdf::changeFormat(array(216, 420));
                        $pdf::reset();
    
                        $pdf::AddPage('L');
    
                        $pdf::setFooterCallback(function ($pdf) {
    
                            // Position at 15 mm from bottom
                            $pdf->SetY(-2);
                            // Set font
                            $pdf->SetFont('helvetica', 'I', 8);
                            // Page number
                            $pdf->Cell(0, 6, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                        });
    
                        $pdf::writeHTML($html, true, false, true, false, '');
    
                        $pdf::Output('designationWiseEmployee.pdf');
    
                        break;
            }
        }


        return view('employee.report.employee-list-index', compact('departments', 'wStatus', 'designations','Bdesignation'));
    }


    public function BaseDesigEmpList(Request $request)
    {

        $departments = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $Bdesignation = BaseDesignation::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $empHistory = EmpHistory::query()->where('company_id', $this->company_id)
            ->with('department')
            ->with('designation')
            ->get();
        
        $empRecomend = EmpRecomended::query()->where('company_id', $this->company_id)
            ->with('department')
            ->with('designation')
            ->get();

       // dd($Bdesignation);

        $wStatus = WorkingStatus::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('id')
            ->pluck('name', 'id');


        if ($request->filled('search_id')) {

            $Bdesignation = BaseDesignation::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->get();

            if ($request->filled('Bdesignation_Id')) {

                $Bdesig_name = BaseDesignation::query()->where('company_id', $this->company_id)
                ->where('status', true)->where('id', $request['Bdesignation_Id'])
                ->pluck('name');

                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id', $this->company_id)
                    ->whereIn('emp_professionals.working_status_id', [1, 2, 8])
                    ->where('base_designation_id', $request['Bdesignation_Id'])
                    ->with('personal')
                    ->with('history')
                    ->with('recomended')
                    ->with('department')
                    ->with('designation')
                    ->with('salary_properties')
                    ->orderBy('emp_professionals.department_id', 'ASC');

                $employees = $employeesQuery->get();
                $enddate = '2021-12-31';
            } else {

                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id', $this->company_id)
                    ->whereIn('emp_professionals.working_status_id', [1, 2, 8])
                    ->with('personal')
                    ->with('history')
                    ->with('recomended')
                    ->with('department')
                    ->with('designation')
                    ->with('salary_properties')
                    ->orderBy('emp_professionals.department_id', 'ASC');

                $employees = $employeesQuery->get();

                $enddate = '2021-12-31';

                $Bdesig_name = null;
                // dd($employees);
            }

            libxml_use_internal_errors(true);

            switch ($request['action']) {
                case    'export':
                    return Excel::download(new EmployeeDesigWiseExport($employees, $Bdesignation, $departments), 'designationWiseEmployee.xlsx');
                    break;


                case    'history':
                    $view = \View::make('employee.report.print.BDesig-employeeHist-list', compact('employees', 'empRecomend','Bdesignation','empHistory','Bdesig_name','enddate'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 9000);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    $pdf::SetMargins(10, 5, 5, 0);

                    $pdf::changeFormat(array(216, 420));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-8);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('designationWiseEmployee.pdf');

                    break;

                    case    'print':

                        //            set_time_limit(180);
                        ini_set('max_execution_time', 9000);
                        ini_set('memory_limit', '1024M');
                        ini_set("output_buffering", 10240);
                        ini_set('max_input_time', 300);
                        ini_set('default_socket_timeout', 300);
                        ini_set('pdo_mysql.cache_size', 4000);
                        ini_set('pcre.backtrack_limit', 10000000);

                        $view = \View::make('employee.report.print.BDesig-employeeList', compact('employees','Bdesignation','Bdesig_name'));
                        $html = $view->render();
    
                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                        $pdf::SetMargins(20, 5, 5, 0);
                        $pdf::AddPage();
                        $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('employeeList.pdf');
    
                        break;
            }
        }


        return view('employee.report.employee-list-index', compact('designations', 'departments', 'wStatus'));
    }

    public function DesigEmpList(Request $request)
    {

        $departments = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        // dd($designations);

        $wStatus = WorkingStatus::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('id')
            ->pluck('name', 'id');


        if ($request->filled('search_id')) {

            if ($request->filled('designation_Id')) {

                $designation = Designation::query()->where('company_id', $this->company_id)
                ->where('status', true)->where('id', $request['designation_Id'])
                ->pluck('name');

                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id', $this->company_id)
                    ->whereIn('emp_professionals.working_status_id', [1, 2, 8])
                    ->where('designation_id', $request['designation_Id'])
                    ->with('personal')
                    ->with('history')
                    ->with('department')
                    ->with('designation')
                  
                    ->with('salary_properties')
                    ->orderBy('emp_professionals.department_id', 'ASC');

                $employees = $employeesQuery->get();
            } else {

                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id', $this->company_id)
                    ->whereIn('emp_professionals.working_status_id', [1, 2, 8])
                    ->with('personal')
                    ->with('history')
                    ->with('department')
                    ->with('designation')
                   
                    ->with('salary_properties')
                    ->orderBy('emp_professionals.department_id', 'ASC');

                $employees = $employeesQuery->get();

                $Bdesig_name = null;
                // dd($employees);
            }

            libxml_use_internal_errors(true);

            switch ($request['action']) {
                case    'export':
                    return Excel::download(new EmployeeDesigWiseExport($employees, $Bdesig_name, $departments), 'BdesignationWiseEmployee.xlsx');
                    break;


                case    'print':
                    $view = \View::make('employee.report.print.rowwise-employee-list', compact('employees', 'designation'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 9000);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    $pdf::SetMargins(10, 5, 5, 0);

                    $pdf::changeFormat(array(216, 420));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-8);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('designationWiseEmployee.pdf');

                    break;
            }
        }


        return view('employee.report.employee-list-index', compact('designations', 'departments', 'wStatus'));
    }

    public function empHistoryList(Request $request)
    {

        $departments = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        $dept_name = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)->where('id', $request['department_id'])
            ->pluck('name');

        // dd($dept_name);

        $designations = Designation::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')
            ->pluck('name', 'id');

        // dd($designations);

        $wStatus = WorkingStatus::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('id')
            ->pluck('name', 'id');


        if ($request->filled('search_id')) {
            $departments = Department::query()->where('company_id', $this->company_id)
                ->where('status', true)
                ->orderBy('name')->get();

            if ($request->filled('department_id')) {

                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id', $this->company_id)
                    ->whereIn('emp_professionals.working_status_id', [1, 2, 8])
                    ->where('department_id', $request['department_id'])
                    ->whereNotIn('designation_id', [18, 19, 20, 21, 74, 75, 76, 77, 78, 79, 80, 81, 82, 211, 286, 291, 295, 212, 303, 304, 310, 311, 320, 322, 27, 28, 29, 30, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 52, 53, 54, 55, 144, 147, 148, 149, 150, 271, 330, 331, 332, 86, 87, 88, 89, 56, 57, 58, 59, 71, 72, 73, 83, 84, 85, 170, 253, 254, 258, 259, 266, 268, 269, 276, 277, 278, 280, 281, 282, 284, 285, 287, 288, 290, 294, 299, 337, 340, 341])
                    ->with('personal')
                    ->with('history')
                    ->with('department')
                    ->with('designation')
                    ->with('salary_properties')
                    ->orderBy('emp_professionals.designation_id', 'ASC');

                $employees = $employeesQuery->get();
            } else {

                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id', $this->company_id)
                    ->whereIn('working_status_id', [1, 2, 8])
                    ->whereNotIn('designation_id', [18, 19, 20, 21, 74, 75, 76, 77, 78, 79, 80, 81, 82, 211, 286, 291, 295, 212, 303, 304, 310, 311, 320, 322, 27, 28, 29, 30, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 52, 53, 54, 55, 144, 147, 148, 149, 150, 271, 330, 331, 332, 86, 87, 88, 89, 56, 57, 58, 59, 71, 72, 73, 83, 84, 85, 170, 253, 254, 258, 259, 266, 268, 269, 276, 277, 278, 280, 281, 282, 284, 285, 287, 288, 290, 294, 299, 337, 340, 341])
                    ->with('personal')
                    ->with('history')
                    ->with('department')
                    ->with('designation')
                    ->with('salary_properties')
                    ->orderBy('department_id', 'ASC');

                $employees = $employeesQuery->get();

                $dept_name = null;
                // dd($employees);
            }


            libxml_use_internal_errors(true);

            switch ($request['action']) {
                case    'export':

                    return Excel::download(new EmployeeDeptWiseExport($employees, $designations, $departments, $dept_name), 'deptWiseEmployee.xlsx');
                    break;

                case    'print':


                    $view = \View::make('employee.report.print.department_rowwise-employee-list', compact('employees', 'designations', 'departments', 'dept_name'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 9000);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::changeFormat(array(216, 420));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });

                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('deptWiseEmployee.pdf');

                    break;
            }
        }


        return view('employee.report.employee-list-index', compact('designations', 'departments', 'wStatus'));
    }
   
public function wStatus(Request $request)
    {

        $employees = EmpProfessional::query()
            ->where('working_status_id', $request['status_id'])
            ->get();

        $status = WorkingStatus::query()->where('id', $request['status_id'])->first();


        $departments = $employees->unique('department_id');
        
        libxml_use_internal_errors(true);

        switch ($request['action']) {
            case    'export':

                return Excel::download(new EmployeeStatusExport($employees,$departments,$status), 'workingstatusEmployee.xlsx');
                break;

            case    'print':

                $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                $html = $view->render();
        
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
        
                ini_set('max_execution_time', 900);
                ini_set('memory_limit', '1024M');
                ini_set("output_buffering", 10240);
                ini_set('max_input_time', 300);
                ini_set('default_socket_timeout', 300);
                ini_set('pdo_mysql.cache_size', 4000);
                ini_set('pcre.backtrack_limit', 5000000);
        
                $pdf::SetMargins(20, 5, 5, 0);
        
                $pdf::AddPage();
        
                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::Output('working-status-employees.pdf');
                break;
        }

       

        return view('employee.report.print.pdf-emp-list-working-status');
    }


    public function DateRangewStatus(Request $request)
    {

        $year = null;
        $month = null;

        $wStatus = WorkingStatus::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('id')
            ->pluck('name', 'id');

        switch ($request['action']) {

            case    'export':

                return Excel::download(new DaterangeEmployeeExport($from_date, $to_date, $employees), 'employee.xlsx');
                break;

            case 'print':

                $from_date = Carbon::createFromFormat('d-m-Y', $request['from_date'])->format('Y-m-d');
                $to_date = Carbon::createFromFormat('d-m-Y', $request['to_date'])->format('Y-m-d');

                libxml_use_internal_errors(true);


                if ($request['status_id'] == 0) {
                    $employees = EmpProfessional::query()
                        ->whereIn('working_status_id', [1, 2, 8])
                        ->whereBetween('joining_date', [$from_date, $to_date])
                        ->get();

                    // dd($employees);

                    $status = WorkingStatus::query()->where('id', 100)->first();

                    // dd($status);

                    $departments = $employees->unique('department_id');

                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);


                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    $pdf::SetMargins(20, 5, 5, 0);
                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 2) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 1)
                        ->get();

                    // dd($employees);

                    $status = WorkingStatus::query()->where('id', 1)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
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
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 3) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 2)
                        ->get();

                    // dd($employees);

                    $status = WorkingStatus::query()->where('id', 2)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 4) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 3)
                        ->whereBetween('status_change_date', [$from_date, $to_date])
                        ->get();

                    // dd($employees);

                    $status = WorkingStatus::query()->where('id', 3)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 5) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 4)
                        ->whereBetween('status_change_date', [$from_date, $to_date])
                        ->get();

                    //  dd($employees);

                    $status = WorkingStatus::query()->where('id', 4)->first();

                    // dd($status);

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 6) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 7)
                        ->whereBetween('status_change_date', [$from_date, $to_date])
                        ->get();

                    //   dd($employees);

                    $status = WorkingStatus::query()->where('id', 7)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 7) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 8)
                        ->get();

                    //dd($employees);

                    $status = WorkingStatus::query()->where('id', 8)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 8) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 9)
                        ->whereBetween('status_change_date', [$from_date, $to_date])
                        ->get();

                    $status = WorkingStatus::query()->where('id', 9)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 9) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 11)
                        ->whereBetween('status_change_date', [$from_date, $to_date])
                        ->get();

                    $status = WorkingStatus::query()->where('id', 11)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 11) {
                    $employees = EmpProfessional::query()
                        ->where('working_status_id', 14)
                        ->whereBetween('status_change_date', [$from_date, $to_date])
                        ->get();

                    $status = WorkingStatus::query()->where('id', 14)->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-emp-list-working-status', compact('employees', 'departments', 'status'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } elseif ($request['status_id'] == 10) {
                    $employees = EmpProfessional::query()
                        ->whereIn('working_status_id', [4, 5, 6, 7, 9, 10, 11, 12, 13, 14])
                        ->whereBetween('status_change_date', [$from_date, $to_date])
                        ->get();

                           $status = 'Left Employee';
                    // $status = WorkingStatus::query()->whereIn('id',[3,4,5,6,7,9,10,11,12])->first();

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-allWorkingEmp_with_Daterange', compact('employees', 'departments', 'status', 'from_date', 'to_date'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                } else {
                    $employees = EmpProfessional::query()
                        ->whereBetween('joining_date', [$from_date, $to_date])
                        ->get();

                    //$status = WorkingStatus::query()->where('company_id', 1)->get();
                    $status = 'New Join';
                    // dd($status);

                    $departments = $employees->unique('department_id');

                    $view = \View::make('employee.report.print.pdf-allWorkingEmp_with_Daterange', compact('employees', 'departments', 'status', 'from_date', 'to_date'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('DateRange employees.pdf');
                }

                break;

            case 'summery':

                $from_date = Carbon::createFromFormat('d-m-Y', $request['from_date'])->format('Y-m-d');
                $to_date = Carbon::createFromFormat('d-m-Y', $request['to_date'])->format('Y-m-d');

                $new_emp = EmpProfessional::query()
                    ->whereBetween('joining_date', [$from_date, $to_date])
                    ->get();

                $regular = EmpProfessional::query()
                    ->where('working_status_id', 1)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $probationary = EmpProfessional::query()
                    ->where('working_status_id', 2)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $suspended = EmpProfessional::query()
                    ->where('working_status_id', 3)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $resigned = EmpProfessional::query()
                    ->where('working_status_id', 4)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $terminated = EmpProfessional::query()
                    ->where('working_status_id', 5)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $u_absent = EmpProfessional::query()
                    ->where('working_status_id', 7)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $contractual = EmpProfessional::query()
                    ->where('working_status_id', 8)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $dismissed = EmpProfessional::query()
                    ->where('working_status_id', 9)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $discontinued = EmpProfessional::query()
                    ->where('working_status_id', 11)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $released = EmpProfessional::query()
                    ->where('working_status_id', 14)
                    ->whereBetween('status_change_date', [$from_date, $to_date])
                    ->get();

                $view = \View::make('employee.report.print.pdf-allEmp_summery', compact('new_emp', 'regular', 'probationary', 'suspended', 'resigned', 'terminated', 'u_absent', 'contractual', 'dismissed', 'discontinued', 'released', 'from_date', 'to_date'));
                $html = $view->render();

                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                $pdf::SetMargins(20, 5, 5, 0);

                $pdf::AddPage();

                $pdf::writeHTML($html, true, false, true, false, '');
                $pdf::Output('DateRange employees.pdf');


                break;
        }

        return view('employee.report.dateEmployee-list-index', compact('wStatus', 'year', 'month'));
    }


    public function MonthwStatus(Request $request)


    {

        if (!empty($request['action'])) {

            switch ($request['action']) {

                case 'print':

                    $year = $request['search_year'];
                    $month = $request['search_month'];
                    $status_id = $request['status_id'];

                    $start_date = $year . '-' . $month . '-' . '01';

                    $last_date_find = strtotime(date("Y-m-d", strtotime($start_date)) . ", last day of this month");
                    $last_date = date("Y-m-d", $last_date_find);

                    //dd($last_date);

                    if ($status_id == 1) {
                        $employees = DailyAttendance::query()
                            ->where('attend_date', $last_date)
                            ->select(
                                'attend_date',
                                'department_id',
                                DB::Raw('count(employee_id) as emp_count')
                            )
                            ->groupBy('attend_date', 'department_id')
                            ->with('department')
                            ->get();


                        $view = \View::make('employee.report.print.pdf-Allemp-list-working-status', compact('employees', 'year', 'month', 'department_id'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LEGAL', true, 'UTF-8', false);

                        //            set_time_limit(180);
                        ini_set('max_execution_time', 900);
                        ini_set('memory_limit', '1024M');
                        ini_set("output_buffering", 10240);
                        ini_set('max_input_time', 300);
                        ini_set('default_socket_timeout', 300);
                        ini_set('pdo_mysql.cache_size', 4000);
                        ini_set('pcre.backtrack_limit', 10000000);

                        $pdf::SetMargins(5, 5, 5, 0);
                        $pdf::AddPage();

                        // for direct print

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('roster.pdf');
                    } else {

                        $employees = EmpProfessional::query()
                            ->whereIn('working_status_id', [4, 5, 6, 7, 9, 10, 11, 12, 13,14])
                            ->whereBetween('status_change_date', [$start_date, $last_date])
                            ->get();

                        // $status = WorkingStatus::query()->whereIn('id',[3,4,5,6,7,9,10,11,12])->first();

                        $departments = $employees->unique('department_id');

                        //dd($departments);

                        $view = \View::make('employee.report.print.pdf-all_leftEmp_with_Daterange', compact('employees', 'departments', 'status', 'start_date', 'last_date'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                        $pdf::SetMargins(20, 5, 5, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DateRange employees.pdf');
                    }

                    break;
            }
        }
    }

    public function doctorEmpList(Request $request)
    {
        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');
        $sections = Section::query()->where('company_id',$this->company_id)
            ->where('status',true)->where('department_id','=',13)
            ->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');

           // dd($designations);

        $wStatus = WorkingStatus::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('id')
            ->pluck('name','id');
          
        $department = $request['department']; 
    
            switch($request['department'])
            {
                case 'all':    
                    
                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                    ->whereIn('emp_professionals.working_status_id',[1,2,8])
                    ->whereIn('emp_professionals.department_id',[13,18,19,21,29,34 ])
                    ->whereIn('emp_professionals.section_id',[21,22,23,24,25,27,28,29,30,32,33,37,34,42,50,53,64,69,
                    70,71,72,73,74,75,76,77,78,79,80,81,82,83])
                    ->with('personal')
                    ->with('department')
                    ->with('designation')                  
                    ->orderBy('emp_professionals.department_id','ASC');

                    $employees = $employeesQuery->get();
                    $sectionss = $employees->unique('section_id');
                    break;
    
                    case 'Clinical':
    
                    $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                        ->whereIn('emp_professionals.working_status_id',[1,2,8])
                        ->where('emp_professionals.department_id','=',13)
                        ->whereIn('emp_professionals.section_id',[21,22,23,24,25,27,28,29,30,32,33,34,37,42,50,53,64,69,70,71,80,81,82,83
                        ])
                        ->with('personal')
                         ->with('department')
                        ->with('designation')
                        ->orderBy('emp_professionals.designation_id','ASC');
    
                        $employees = $employeesQuery->get();
                        $sectionss = $employees->unique('section_id');
                    break;
    
            }
     
            //dd($employees);


            libxml_use_internal_errors(true);

            switch($request['action'])
            {
                case 'export':

                    return Excel::download(new EmployeeDesigWiseExport($employees,$designations,$departments,$sections), 'designationWiseEmployee.xlsx');
                    break;

                case 'print':

                    $view = \View::make('employee.report.print.all-Doctor-section-employee-list', compact('employees','designations','sectionss','department'));
                    $html = $view->render();
                  
                   // $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 9000);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);
                   

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    $pdf::SetMargins(20, 5, 5,0);
                    $pdf::AddPage('L');
                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('deptWiseEmployee.pdf');
            break;

            }
       
        return view('employee.report.employee-doctor-list-index',compact('sections'));
    }

    public function sectionWiseEmpList(Request $request)
    {

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');
     
        $sections = Section::query()->where('company_id',$this->company_id)
        
        ->where('status',true)
        ->pluck('name','id');
         
  

        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');

        

        $wStatus = WorkingStatus::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('id')
            ->pluck('name','id');
        

           
    if($request['department_id']){

      
   
        $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
        ->whereIn('emp_professionals.working_status_id',[1,2,8])
       
        ->where('emp_professionals.department_id',$request['department_id'])
         
        ->with('personal')
         ->with('department')
        ->with('designation')
      
        ->orderBy('emp_professionals.designation_id','ASC');

        $dept_name = Department::query()->where('company_id',$this->company_id)
        ->where('status',true)->where('id',$request['department_id'])
        ->pluck('name');

        $employees = $employeesQuery->get();
        $sectionss = $employees->unique('section_id');
      
    }
                
  else{
    $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
            ->whereIn('emp_professionals.working_status_id',[1,2,8])
         
            ->where('emp_professionals.section_id',$request['sec'])
             
            ->with('personal')
             ->with('department')
            ->with('designation')
          
            ->orderBy('emp_professionals.designation_id','ASC');

            $dept_name = null;


            $employees = $employeesQuery->get();
            $sectionss = $employees->unique('section_id');
  }
        
              // dd($employees);

            libxml_use_internal_errors(true);

            switch($request['action'])
            {
                case    'export':

                    return Excel::download(new EmployeeSecWiseExport($employees,$sectionss,$dept_name), 'sectionWiseEmployee.xlsx');
                    break;
                 
                case    'print':
                 
                    $view = \View::make('employee.report.print.Pdf-all-emp-section-list', compact('employees','sectionss','dept_name'));
                    $html = $view->render();
                  
                   // $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 9000);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);
                   

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    $pdf::SetMargins(20, 5, 5,0);
                    $pdf::AddPage();
                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('deptSectionWiseEmployee.pdf');

            break;

            }
    

        return view('employee.report.employee-section-list-index',compact('sections','departments'));
    }
    
    public function sectionDoctorEmpList(Request $request)
    {

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');
       

        $dept_name = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->where('id',$request['department_id'])
            ->pluck('name');
            $sections = Section::query()->where('company_id',$this->company_id)
            ->where('status',true)->where('department_id','=',13)
            ->pluck('name','id');
           // dd($sec_name);

        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');

           // dd($designations);

        $wStatus = WorkingStatus::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('id')
            ->pluck('name','id');
        

            $department = $request['department']; 
             
  $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                ->whereIn('emp_professionals.working_status_id',[1,2,8])
              ->where('emp_professionals.department_id','=',13)
                ->where('emp_professionals.section_id',$request['id'])
                 
                ->with('personal')
                 ->with('department')
                ->with('designation')
              
                ->orderBy('emp_professionals.designation_id','ASC');


                $employees = $employeesQuery->get();
                $sectionss = $employees->unique('section_id');

                //dd($today);

            libxml_use_internal_errors(true);

            switch($request['action'])
            {
                case    'export':

                    return Excel::download(new EmployeeDeptWiseExport($employees,$designations,$departments,$dept_name), 'deptWiseEmployee.xlsx');
                    break;
                 
                case    'print':
                 
                    $view = \View::make('employee.report.print.all-Doctor-section-employee-list', compact('employees','designations','sectionss','dept_name','department','today','joinDay'));
                    $html = $view->render();
                  
                   // $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 9000);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);
                   

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    $pdf::SetMargins(20, 5, 5,0);
                    $pdf::AddPage('L');
                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('deptWiseEmployee.pdf');

            break;

            }
    

        return view('employee.report.employee-doctor-list-index',compact('month','sections'));
    }


public function specialDoctorEmpList(Request $request)
    {
        if(check_privilege(749,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');
        $sections = Section::query()->where('company_id',$this->company_id)
                ->where('status',true)->where('department_id','=',13)
                ->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name')
            ->pluck('name','id');

           // dd($designations);

        $wStatus = WorkingStatus::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('id')
            ->pluck('name','id');
            $year = null;
            $month = null;
        
            $year = $request['search_year'];
            $month = $request['search_month'];
            $status_id = $request['status_id'];

            $start_date = $year.'-'.$month.'-'.'01' ; 

            $last_date_find = strtotime(date("Y-m-d", strtotime($start_date)) . ", last day of this month");
            $last_date = date("Y-m-d",$last_date_find);

            $special_id = $request['special_id']; 
    
            switch($request['special_id'])
                {
    
                    case 'consultant':
    
                    
      $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                    ->whereIn('emp_professionals.working_status_id',[1,2,8])
                  
                    ->whereIn('emp_professionals.designation_id',[71,72,73,83,85,170,253,254,258,259,268,276,277,278,280,287,288,294,
                       337,340,341,353,367,368,376,377,378,379,388,390,395,397,401,402,405
                       ])
                    ->with('personal')
                    ->with('department')
                    ->with('designation')
                  
                    ->orderBy('emp_professionals.designation_id','ASC');


                    $employees = $employeesQuery->get();
                    $sectionss = $employees->unique('section_id');
    
                  // dd($employees);
    
                         //   dump($employeesQuery->toSql());
    
                        break;
    
                    case 'register':
    
                    
                        $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                        ->whereIn('emp_professionals.working_status_id',[1,2,8])
                      
                        ->whereIn('emp_professionals.designation_id',[211,375,380,381,382,384,399,400,404
                                         ])
                        ->with('personal')
                         ->with('department')
                        ->with('designation')
                      
                        ->orderBy('emp_professionals.designation_id','ASC');
    
    
                        $employees = $employeesQuery->get();
                        $sectionss = $employees->unique('section_id');
    
    
                        break;
                        case 'asstregister':
    
                    
                            $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                            ->whereIn('emp_professionals.working_status_id',[1,2,8])
                          
                            ->whereIn('emp_professionals.designation_id',[257,299,303,304,371,373
                                             ])
                            ->with('personal')
                             ->with('department')
                            ->with('designation')
                          
                            ->orderBy('emp_professionals.designation_id','ASC');
        
        
                            $employees = $employeesQuery->get();
                            $sectionss = $employees->unique('section_id');
        
        
                            break;

                        case 'specialist':
    
                    
                            $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                            ->whereIn('emp_professionals.working_status_id',[1,2,8])
                          
                            ->whereIn('emp_professionals.designation_id',[84,255,266,269,281,282,284,285,290,351,354,372,374
                          
                            ])
                            ->with('personal')
                             ->with('department')
                            ->with('designation')
                          
                            ->orderBy('emp_professionals.designation_id','ASC');
        
        
                            $employees = $employeesQuery->get();
                            $sectionss = $employees->unique('section_id');
        
        
                            break;
                            case 'clinicalStaff':
    
                    
                                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                                ->whereIn('emp_professionals.working_status_id',[1,2,8])
                              
                                ->whereIn('emp_professionals.designation_id',[172,212,217,333
                              
                                ])
                                ->with('personal')
                                 ->with('department')
                                ->with('designation')
                              
                                ->orderBy('emp_professionals.designation_id','ASC');
            
            
                                $employees = $employeesQuery->get();
                                $sectionss = $employees->unique('section_id');
            
            
                                break;
                            case 'smo':
    
                    
                                $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                                ->whereIn('emp_professionals.working_status_id',[1,2,8])
                              
                                ->whereIn('emp_professionals.designation_id',[78,79,80,81,82,286,291,295
                                
                                ])
                                ->with('personal')
                                 ->with('department')
                                ->with('designation')
                              
                                ->orderBy('emp_professionals.designation_id','ASC');
            
            
                                $employees = $employeesQuery->get();
                                $sectionss = $employees->unique('section_id');
            
            
                                break;
                                case 'mo':
    
                    
                                    $employeesQuery = EmpProfessional::query()->where('emp_professionals.company_id',$this->company_id)
                                    ->whereIn('emp_professionals.working_status_id',[1,2,8])
                                  
                                    ->whereIn('emp_professionals.designation_id',[74,75, 76, 77,310, 311, 320,322 
                                    
                                    ])
                                    ->with('personal')
                                     ->with('department')
                                    ->with('designation')
                                  
                                    ->orderBy('emp_professionals.designation_id','ASC');
                
                
                                    $employees = $employeesQuery->get();
                                    $sectionss = $employees->unique('section_id');
                
                //dd($employees);
                                    break;
    
                    }
           

            libxml_use_internal_errors(true);

            switch($request['action'])
            {
                case    'export':

                    return Excel::download(new EmployeeDesigWiseExport($employees,$designation,$departments,$sections), 'designationWiseEmployee.xlsx');
                    break;

                case    'print':

                    $view = \View::make('employee.report.print.all-Doctor-section-employee-list', compact('employees','designations','sectionss','special_id'));
                    $html = $view->render();
                  
                   // $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 9000);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);
                   

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    $pdf::SetMargins(20, 5, 5,0);
                    $pdf::AddPage('L');
                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('doctorWiseEmployee.pdf');


            break;

            }
       


        return view('employee.report.employee-doctor-list-index',compact('month','sections'));
    }


    public function DateRangePunishStatus(Request $request)


    {

        if (!empty($request['action'])) {

            switch ($request['action']) {

                case 'print':

                    $from_date = Carbon::createFromFormat('d-m-Y', $request['from_date1'])->format('Y-m-d');
                    $to_date = Carbon::createFromFormat('d-m-Y', $request['to_date1'])->format('Y-m-d');


                    if ($request['punish_id'] == 1) {
                        $employees = Punish::query()
                            ->where('punish_id', 1)
                            ->whereBetween('effective_date', [$from_date, $to_date])
                            ->get();

                        // dd($employees);

                        $status = "Suspended";

                        // dd($status);

                        $departments = $employees->unique('department_id');

                        // dd($departments);


                        $view = \View::make('employee.report.print.pdf-Punishemp-list', compact('employees', 'status', 'departments', 'from_date', 'to_date'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                        $pdf::SetMargins(20, 5, 5, 0);
                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DateRange Punish employees.pdf');
                    } elseif ($request['punish_id'] == 2) {
                        $employees = Punish::query()
                            ->where('punish_id', 2)
                            ->whereBetween('effective_date', [$from_date, $to_date])
                            ->get();

                        // dd($employees);

                        $status = "Show Cause";

                        $departments = $employees->unique('department_id');


                        $view = \View::make('employee.report.print.pdf-Punishemp-list', compact('employees', 'status', 'departments', 'from_date', 'to_date'));
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
                        $pdf::Output('DateRange Punish employees.pdf');
                    } elseif ($request['punish_id'] == 3) {
                        $employees = Punish::query()
                            ->where('punish_id', 3)
                            ->whereBetween('effective_date', [$from_date, $to_date])
                            ->get();

                        $status = "Warning";

                        $departments = $employees->unique('department_id');


                        $view = \View::make('employee.report.print.pdf-Punishemp-list', compact('employees', 'status', 'departments', 'from_date', 'to_date'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                        $pdf::SetMargins(20, 5, 5, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DateRange Punish employees.pdf');
                    } elseif ($request['punish_id'] == 4) {
                        $employees = Punish::query()
                            ->where('punish_id', 4)
                            ->whereBetween('effective_date', [$from_date, $to_date])
                            ->get();

                        $status = "Miscellaneous";

                        $departments = $employees->unique('department_id');


                        $view = \View::make('employee.report.print.pdf-Punishemp-list', compact('employees', 'status', 'departments', 'from_date', 'to_date'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                        $pdf::SetMargins(20, 5, 5, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DateRange Punish employees.pdf');
                    } else {
                        $employees = Punish::query()
                            ->whereIn('punish_id', [1, 2, 3, 4])
                            ->whereBetween('effective_date', [$from_date, $to_date])
                            ->get();

                        $status = Punish::query()
                            ->whereBetween('effective_date', [$from_date, $to_date])
                            ->pluck('punish_id');

                        // dd($status);



                        $departments = $employees->unique('department_id');


                        $view = \View::make('employee.report.print.pdf-All-Punishemp-list', compact('employees', 'status', 'departments', 'from_date', 'to_date'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                        $pdf::SetMargins(20, 5, 5, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DateRange Punish employees.pdf');
                    }

                    break;
            }
        }
    }

    public function genderList(Request $request)

    {
        if (!empty($request['action'])) {
            switch ($request['action']) {
                case 'print':

                    if ($request['gender'] == 'M') {
                        $employees = EmpPersonal::query()
                            ->where('gender', 'M')
                            ->get();

                        // dd($employees);

                        $departments = $employees->unique('department_id');

                        // dd($departments);

                        $view = \View::make('employee.report.print.pdf-Genderemp-list', compact('employees', 'departments'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                        $pdf::SetMargins(20, 5, 5, 0);
                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DateRange Gender employees.pdf');
                    } elseif ($request['gender'] == 'F') {
                        $employees = EmpPersonal::query()
                            ->where('gender', 'F')
                            ->get();

                        $departments = $employees->unique('department_id');


                        $view = \View::make('employee.report.print.pdf-Genderemp-list', compact('employees', 'departments'));
                        $html = $view->render();

                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);


                        $pdf::SetMargins(20, 5, 5, 0);

                        $pdf::AddPage();

                        $pdf::writeHTML($html, true, false, true, false, '');
                        $pdf::Output('DateRange Gender employees.pdf');
                    }

                    break;
            }
        }
    }
}
