<?php

namespace App\Http\Controllers\Roster;

use App\Models\Attendance\DailyAttendance;
use App\Models\Employee\EmpProfessional;
use App\Models\Roster\Roster;
use App\Models\Common\Department;
use App\Models\Roster\Shift;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShiftWiseEmployeeReportController extends Controller
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

        if(check_privilege(26,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

       $shifts = Shift::query()->where('company_id',$this->company_id)
           ->where('status',true)->pluck('name','id');

       $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');

        $year = null;
        $month = null;


        if(!empty($request['action']))
        {

            $year = Carbon::createFromFormat('d-m-Y',$request['report_date'])->format('Y');
            $month = Carbon::createFromFormat('d-m-Y',$request['report_date'])->format('m');
            $day = Carbon::createFromFormat('d-m-Y',$request['report_date'])->format('d');
            $date = $request['report_date'];
            $field = 'day_'.$day;
            //$session_id = $request['session_id'];

            

           switch($request['action'])
            {

            	case 'print':

            	$shiftId = $request['shift_id'];

                $shiftName = Shift::query()->where('company_id',$this->company_id)
                                           ->where('status',true)->where('id',$shiftId)->get();

                $departmentId = $request['department_id'];

                //dd($departmentId);

                if(($request->filled('department_id')) && ($request->filled('shift_id'))) {

                    $employees = EmpProfessional::query()
                        ->where('company_id',$this->company_id)
                        ->where('department_id',$departmentId)
                        ->whereIn('working_status_id',[1,2,8])
                        ->whereHas('roster',function ($query) use($year,$month,$day,$shiftId){
                            $query->where('r_year',$year)->where('month_id',$month)
                                ->where('day_'.$day,$shiftId);
                        })->get();

                     $departments = null;
                     $departmentName = Department::query()->where('company_id',$this->company_id)
                                ->where('status',true)->where('id',$departmentId)->pluck('name');
                }
                elseif(($request->filled('shift_id')) &&  ($departmentId == null))
                {

                    $employees = EmpProfessional::query()->where('company_id',$this->company_id)
                        ->whereIn('working_status_id',[1,2,8])
                        ->whereHas('roster',function ($query) use($year,$month,$day,$shiftId){
                            $query->where('r_year',$year)->where('month_id',$month)->where('day_'.$day,$shiftId);})->get();

                    $departments = $employees->unique('department_id');

                }
                elseif(($request->filled('department_id')) &&  ($shiftId == null))
                {

                    $employees = EmpProfessional::query()->where('company_id',$this->company_id)
                        ->whereIn('working_status_id',[1,2,8])
                        ->where('department_id',$departmentId)
                        ->whereHas('roster',function ($query) use($year,$month,$day){
                            $query->where('r_year',$year)->where('month_id',$month);})->get();

                    $departments = null;
                     $departmentName = Department::query()->where('company_id',$this->company_id)
                                ->where('status',true)->where('id',$departmentId)->pluck('name');

                }
                elseif(($departmentId == null) &&  ($shiftId == null))
                {

                    $employees = EmpProfessional::query()->where('company_id',$this->company_id)
                        ->whereIn('working_status_id',[1,2,8])
                        ->whereHas('roster',function ($query) use($year,$month,$day,$shiftId){
                            $query->where('r_year',$year)->where('month_id',$month);
                        })->get();

                    $departments = $employees->unique('department_id');
                }

                //dd($employees);
               
            	break;
               

            }

            

            $view = \View::make('roster.report.pdf.department-wise-employee-shiftprint',compact('employees','departments','shiftId','date','field','departmentName'));
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

            //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

            $pdf::SetMargins(20, 5, 5,0);

            $pdf::AddPage();

            // for direct print

            $pdf::writeHTML($html, true, false, true, false, '');

            $pdf::Output('roster.pdf');

        }

        return view('roster.report.shift-wise-employee-index',compact('shifts','departments'));

    }

    public function shiftEmployee(Request $request)
    {

        if(check_privilege(26,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

       $shifts = Shift::query()->where('company_id',$this->company_id)
           ->where('status',true)->get();

       $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');

        $year = null;
        $month = null;


        if(!empty($request['action']))
        {

            $year = Carbon::createFromFormat('d-m-Y',$request['report_date1'])->format('Y');
            $month = Carbon::createFromFormat('d-m-Y',$request['report_date1'])->format('m');
            $day = Carbon::createFromFormat('d-m-Y',$request['report_date1'])->format('d');
            $date = $request['report_date1'];
            $field = 'day_'.$day;
            //$session_id = $request['session_id'];

            

           switch($request['action'])
            {

                case 'print':

                $shiftId = $request['shift_id'];

                $shiftName = Shift::query()->where('company_id',$this->company_id)
                                           ->where('status',true)->where('id',$shiftId)->get();

                $departmentId = $request['department_id'];

                //dd($departmentId);

                if(($request->filled('department_id')) && ($request->filled('shift_id'))) {

                    $employees = EmpProfessional::query()
                        ->where('company_id',$this->company_id)
                        ->where('department_id',$departmentId)
                        ->whereIn('working_status_id',[1,2,8])
                        ->whereHas('roster',function ($query) use($year,$month,$day,$shiftId){
                            $query->where('r_year',$year)->where('month_id',$month)
                                ->where('day_'.$day,$shiftId);
                        })->get();

                     $departments = null;
                     $departmentName = Department::query()->where('company_id',$this->company_id)
                                ->where('status',true)->where('id',$departmentId)->pluck('name');
                }
                elseif(($request->filled('department_id')) &&  ($shiftId == null))
                {

                    $employees = EmpProfessional::query()->where('company_id',$this->company_id)
                        ->whereIn('working_status_id',[1,2,8])
                        ->where('department_id',$departmentId)
                        ->whereHas('roster',function ($query) use($year,$month,$day){
                            $query->where('r_year',$year)->where('month_id',$month);})->get();

                    $rosters = Roster::query()->where('company_id',$this->company_id)
                        ->where('r_year',$year)
                        ->where('month_id',$month)
                        ->where('department_id',$departmentId)
                        ->whereHas('professional',function ($query) use($departmentId){
                            $query->whereIn('working_status_id',[1,2,8])->where('department_id',$departmentId);})->get();

                    $departments = null;
                    $departmentName = Department::query()->where('company_id',$this->company_id)
                                ->where('status',true)->where('id',$departmentId)->pluck('name');

                }

                //dd($shiftId);
               
                break;
               

            }            

            $view = \View::make('roster.report.pdf.shift-wise-employee-print',compact('employees','departments','shiftId','date','field','departmentName','shifts','rosters'));
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

            //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

            $pdf::SetMargins(20, 5, 5,0);

            $pdf::AddPage();

            // for direct print

            $pdf::writeHTML($html, true, false, true, false, '');

            $pdf::Output('roster.pdf');

        }

        return view('roster.report.shift-wise-employee-index',compact('shifts','departments'));

    }
}
