<?php

namespace App\Http\Controllers\Overtime\Report;

use App\Models\Common\Department;
use App\Models\Employee\EmpProfessional;
use App\Models\Overtime\OvertimeSetup;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeOvertimeExport;

class EmployeeOvertimeController extends Controller
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
        if(check_privilege(55,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('name','ASC')
            ->pluck('name','id');

        if (!empty($request['action']))
        {
            $from_date = Carbon::createFromFormat('d-m-Y', $request['from_date'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request['to_date'])->format('Y-m-d');
            $department_id = $request['department_id'];
            $dept_data = Department::query()->where('company_id', $this->company_id)->where('id', $request['department_id'])->first();

            $dates = createDateRange($from_date, getNextDay($to_date) ,'Y-m-d');


            $data = OvertimeSetup::query()
                ->where('company_id', $this->company_id)
                ->whereBetween('ot_date', [$from_date, $to_date])
                ->where('actual_overtime_hour','>',0)
                ->with('professional')
                ->whereHas('professional',function ($query) use($department_id){
                    $query->where('department_id',$department_id);
                })
                ->with('approver')
                ->with('user')
                ->orderBy('ot_date','ASC')
                ->get();

            $summary = Collect();
            $new = [];


//            dd($data);

            $employees = $data->unique('employee_id');


            foreach ($employees as $row)
            {
                $st_sub_total = 0;

                foreach ($dates as $dt)
                {
                    $s_ot = 0;
                    foreach ($data as $empdata)
                    {
                        if(($empdata->employee_id == $row->employee_id) and ($empdata->ot_type == 'S') and($empdata->ot_date == $dt))
                            {
                                $s_ot = $empdata->actual_overtime_hour;
                                $st_sub_total = $st_sub_total + $empdata->actual_overtime_hour;
                            }
                    }

                    $new['d'.Carbon::parse($dt)->format('d')] = $s_ot;
                }

                $new['employee_id'] = $row->employee_id;
                $new['name'] = $row->professional->personal->full_name;
                $new['designation'] = $row->professional->designation->name;
                $new['pf_no'] = $row->professional->pf_no;
                $new['ot_type'] ='S/D';
                $new['total_sot'] = $st_sub_total;
                $new['gr_total'] = 0;
                $summary->push($new);


                $ot_sub_total = 0;

                foreach ($dates as $dt)
                {
                    $o_ot = 0;
                    foreach ($data as $empdata)
                    {
                        if(($empdata->employee_id == $row->employee_id) and ($empdata->ot_type == 'O') and($empdata->ot_date == $dt))
                        {
                            $o_ot = $empdata->actual_overtime_hour;
                            $ot_sub_total= $ot_sub_total + $empdata->actual_overtime_hour;

                        }
                    }

                    $new['d'.Carbon::parse($dt)->format('d')] = $o_ot;
                }

                $new['employee_id'] = $row->employee_id;
                $new['name'] = $row->professional->personal->full_name;
                $new['designation'] = $row->professional->designation->name;
                $new['pf_no'] = $row->professional->pf_no;
                $new['ot_type'] ='O/D';
                $new['total_sot'] = $ot_sub_total;
                $new['gr_total'] = 0;
                $summary->push($new);

                $ht_sub_total = 0;

                foreach ($dates as $dt)
                {
                    $h_ot = 0;
                    foreach ($data as $empdata)
                    {
                        if(($empdata->employee_id == $row->employee_id) and ($empdata->ot_type == 'H') and($empdata->ot_date == $dt))
                        {
                            $h_ot = $empdata->actual_overtime_hour;
                            $ht_sub_total = $ht_sub_total + $empdata->actual_overtime_hour;
                        }
                    }

                    $new['d'.Carbon::parse($dt)->format('d')] = $h_ot;
                }

                $new['employee_id'] = $row->employee_id;
                $new['name'] = $row->professional->personal->full_name;
                $new['designation'] = $row->professional->designation->name;
                $new['pf_no'] = $row->professional->pf_no;
                $new['ot_type'] ='H/D';
                $new['total_sot'] = $ht_sub_total;
                $new['gr_total'] = $ht_sub_total + $ot_sub_total + $st_sub_total;
                $summary->push($new);


            }

//            dd($summary);

            $employees = $summary->unique('employee_id');

            libxml_use_internal_errors(true);



            switch ($request['action']) {


                case 'preview':

                    $view = \View::make('overtime.report.print-employee-overtime', compact('summary', 'from_date', 'to_date', 'dept_data', 'departments','dates','employees'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216,355), true, 'UTF-8', false);

                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time',300);
                    ini_set('default_socket_timeout',300);
                    ini_set('pdo_mysql.cache_size',4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $pdf::SetMargins(10, 5, 5,0);
                    $pdf::changeFormat(array(216,355));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('overtime.pdf');

                    break;

                case 'print':


                    $view = \View::make('overtime.report.print-employee-overtime', compact('summary', 'from_date', 'to_date', 'dept_data', 'departments','dates','employees'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216,355), true, 'UTF-8', false);

                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time',300);
                    ini_set('default_socket_timeout',300);
                    ini_set('pdo_mysql.cache_size',4000);
                    ini_set('pcre.backtrack_limit', 5000000);
                    
                    $pdf::SetMargins(10, 5, 5,0);
                    $pdf::changeFormat(array(216,355));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('overtime.pdf');

                    break;

                    case 'excel':

                    return Excel::download(new EmployeeOvertimeExport($summary,$from_date, $to_date, $dept_data, $departments,$dates,$employees), 'EmployeeOvertimeExport.xls');

            }
        }

        return view('overtime.report.employee-overtime-report-index',compact('departments'));
    }
}
