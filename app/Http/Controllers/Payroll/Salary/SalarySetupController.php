<?php

namespace App\Http\Controllers\Payroll\Salary;

use App\Models\Common\Bank;
use App\Models\Common\Department;
use App\Models\Employee\EmpProfessional;
use App\Models\Payroll\SalarySetup;
use App\Models\Payroll\AdvanceSetup;
use App\Models\Payroll\ArearSetup;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SalarySetupController extends Controller
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

        if(check_privilege(701,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $department_id = null;

        $departments = Department::query()->where('company_id',1)
            ->where('status',true)
            ->orderBy('name','ASC')
            ->pluck('name','id');

        $banks = Bank::query()->where('company_id',1)
            ->where('status',true)
            ->orderBy('name','ASC')
            ->pluck('name','id');


        if(!empty($request['department_id']))
        {
            $department_id = $request['department_id'];

            switch ($request['action'])
            {
                case 'setup':
                    return view('payroll.salary.salary-setup-index',compact('departments','department_id','banks'));
                    break;

                case 'print':

//                    $salaries = EmpProfessional::query()->where('company_id',1)
//                        ->whereIn('working_status_id',[1,2,8])
//                        ->where('department_id',$department_id)
//                        ->with(['designation'=>function($q) {
//                            $q->orderBy('precedence');
//                        }])
//                        ->with('salary_properties')->get();

                    $salaries = EmpProfessional::query()->where('emp_professionals.company_id',1)
                        ->whereIn('emp_professionals.working_status_id',[1,2,8])
                        ->where('department_id',$department_id)
                        ->join('designations','designations.id','=','emp_professionals.designation_id')
                        ->orderBy('designations.precedence')
                        ->select('emp_professionals.*')
                        ->with('salary_properties')->get();


                    $department = Department::query()->where('id',$department_id)->first();

                    $department = str_replace('department', ' ', $department->name);

                    $sections = $salaries->unique('section_id');

                    $sections = $sections->sortBy('section_id');


                    $view = \View::make('payroll.salary.report.pdf-salary-setups', compact('salaries', 'sections','department'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216,355), true, 'UTF-8', false);

                    $pdf::SetMargins(10, 5, 5,0);
                    $pdf::changeFormat(array(216,355));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('setup.pdf');
            }

        }

        return view('payroll.salary.salary-setup-index',compact('departments','department_id','banks'));
    }

    public function employeeData($id)
    {
        $employees = EmpProfessional::query()->where('company_id',1)
            ->whereIn('working_status_id',[1,2,8])
            ->where('department_id',$id)
            ->with('personal')
            ->with('salary_properties')
            ->get();

        return DataTables::of($employees)

            ->addColumn('action', function ($employees) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$employees->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>
                    
                    <button data-remote="setup/'. $employees->id . '" 
                        data-employee_id="'. $employees->employee_id . '" data-basic="'. $employees->salary_properties->basic . '"
                        
                        data-ot_basic="'. $employees->salary_properties->ot_basic . '"
                        data-house_rent="'. $employees->salary_properties->house_rent . '"
                        data-medical="'. $employees->salary_properties->medical . '"
                        data-conveyance="'. $employees->salary_properties->conveyance . '"
                        data-entertainment="'. $employees->salary_properties->entertainment . '"
                        data-other_allowance="'. $employees->salary_properties->other_allowance . '"
                        data-gross_salary="'. $employees->salary_properties->gross_salary . '"
                        data-cash_salary="'. $employees->salary_properties->cash_salary . '"
                        data-bank_id="'. $employees->salary_properties->bank_id . '"
                        data-account_no="'. $employees->salary_properties->account_no . '"
                        data-tds_id="'. $employees->salary_properties->tds . '"
                        data-income_tax="'. $employees->salary_properties->income_tax . '"
                        data-advance="'. $employees->salary_properties->advance . '"
                        data-mobile_others="'. $employees->salary_properties->mobile_others . '"
                        data-stamp_fee="'. $employees->salary_properties->stamp_fee . '"
                        
                        type="button" class="btn btn-sm btn-salary-setup btn-primary pull-center" data-toggle="modal" data-target="#salary-set-modal"><i class="fa fa-edit" >Setup</i></button>
                    </div>
                    
                    ';
            })

            ->addColumn('designation', function ($employees) {

                return isset($employees->designation_id) ? $employees->designation->name . '<br/> <span style="color: #0c5460">'.$employees->department->name .'</span>' : '';
            })

            ->addColumn('basic', function ($employees) {

                return isset($employees->salary_properties->basic) ? $employees->salary_properties->basic : 0;
            })



            ->editColumn('showimage', function ($employees) {
                if (!isset($employees->personal->photo)) {
                    return "Photo";
                }
                return '<img src="' . asset($employees->personal->photo) .
                    '" alt=" " style="height: 50px; width: 50px;" >';
            })

            ->rawColumns(['action','showimage','designation','basic'])
            ->make(true);
    }

    public function create(Request $request)
    {


        if(check_privilege(701,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $department_id =  EmpProfessional::query()->where('company_id',$this->company_id)->where('employee_id',$request['employee_id'])->first();

        DB::beginTransaction();

        try {

            $properties = SalarySetup::query()->updateOrCreate(
                ['company_id' => $this->company_id, 'employee_id' => $request['employee_id']],
                ['basic' => $request['basic'], 'house_rent' => $request['house_rent'],
                'medical' => $request['medical'], 'entertainment' => $request['entertainment'],
                'conveyance' => $request['conveyance'], 'other_allowance' => $request['other_allowance'],
                'gross_salary' => $request['gross_salary'], 'bank_id' => $request['bank_id'],
                'cash_salary'=>$request['cash_salary'],
                'account_no' => $request['account_no'], 'advance' => $request['advance'],
                'tds' => $request['tds_id'], 'income_tax' => $request['income_tax'],
                'mobile_others' => $request['mobile_others'], 'food' => $request['food'],
                'user_id'=>$this->user_id
                ]
            );

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return redirect()->action('Payroll\Salary\SalarySetupController@index',['department_id'=>$department_id->department_id]);
    }




}

