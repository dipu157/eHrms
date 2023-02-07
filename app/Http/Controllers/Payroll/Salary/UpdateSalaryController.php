<?php

namespace App\Http\Controllers\Payroll\Salary;

use App\Models\Common\Bank;
use App\Models\Common\OrgCalender;
use App\Models\Payroll\MonthlySalary;
use App\Models\Payroll\Heldup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UpdateSalaryController extends Controller
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
        if(check_privilege(701,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $period = OrgCalender::query()->where('salary_update','O')->first();

        $employees = MonthlySalary::query()->where('company_id',$this->company_id)
            ->where('period_id',$period->id)
            ->with('professional')
            ->get();


        return view('payroll.salary.update-salary-index',compact('employees','period'));
    }


    public function salaryData()
    {

        $period = OrgCalender::query()->where('salary_update','O')->first();

        $salaries = MonthlySalary::query()->where('company_id',$this->company_id)
            ->where('period_id',$period->id)
            ->with('professional')
            ->get();

        return DataTables::of($salaries)

            ->addColumn('action', function ($salaries) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="editSalary/'.$salaries->id.'"  type="button" class="btn btn-edit btn-sm btn-secondary"><i class="fa fa-open">Edit</i></button>
                    ';
            })

            ->addColumn('name', function ($salaries) {

                return $salaries->professional->personal->full_name. '<br> <span style="color: #7d0000">' .$salaries->professional->employee_id.'</span>';
            })

            ->addColumn('designation', function ($salaries) {

                return isset($salaries->professional->designation_id) ? $salaries->professional->designation->name . '<br/> <span style="color: #0c5460">'.$salaries->professional->department->name .'</span>' : '';
            })

            ->editColumn('showimage', function ($salaries) {
                if (!isset($salaries->professional->personal->photo)) {
                    return "Photo";
                }
                return '<img src="' . asset($salaries->professional->personal->photo) .
                    '" alt=" " style="height: 50px; width: 50px;" >';
            })

            ->rawColumns(['action','showimage','designation','name'])
            ->make(true);
    }

    public function editIndex($id)
    {

        $banks = Bank::query()->where('company_id',1)
            ->where('status',true)
            ->orderBy('name','ASC')
            ->pluck('name','id');

        $salary = MonthlySalary::query()->where('id',$id)
            ->with('professional')
            ->first();


        return view('payroll.salary.edit-employee-salary-index',compact('salary','banks'));
    }

    public function update(Request $request)
    {

        $period = OrgCalender::query()->where('id',$request['period_id'])->first();

        $earned_salary = round(($request['gross_salary']/$period->nods)*$request['paid_days']);

        $net_salary = $earned_salary + $request['increment_amt'] + $request['arear_amount']
                + $request['overtime_amount'] - $request['income_tax'] - $request['advance']
            - $request['mobile_others'] - $request['stamp_fee'] - $request['food_charge'];

        $payable = $earned_salary + $request['increment_amt'] + $request['arear_amount'] + $request['overtime_amount'];

//        dd($net_salary);

        DB::beginTransaction();

        try {

            if($request->has('withheld'))
            {
                Heldup::query()->updateOrCreate(['company_id'=>$this->company_id,'employee_id'=>$request['employee_id']],['period_id'=>$period->id,'withheld'=>true,'paid_days'=>$request['paid_days'],'reason'=>$request['reason'],'user_id'=>$this->user_id,'status'=>true]);

            }else
            {
                Heldup::query()->updateOrCreate(['company_id'=>$this->company_id,'employee_id'=>$request['employee_id']],['period_id'=>$period->id,'withheld'=>false,'paid_days'=>$request['paid_days'],'reason'=>$request['reason'],'user_id'=>$this->user_id,'status'=>true]);
            }


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['net_salary'=>$net_salary]);
    }
}
