<?php

namespace App\Http\Controllers\Payroll\Salary;

use App\Models\Common\OrgCalender;
use App\Models\Employee\EmpProfessional;
use App\Models\Payroll\Arear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArearSetupController extends Controller
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
        if(check_privilege(720,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = Arear::query()->where('company_id',$this->company_id)
                ->with('professional')
                ->orderBy('id','desc')
                ->take(10)
                ->get();

        if($request->filled('search_id'))
        {

            $data = Arear::query()->where('company_id',$this->company_id)
                ->where('employee_id',$request['search_id'])
                ->with('professional')
                ->orderBy('id','desc')
                ->get();

        }

        return view('payroll.salary.arear-setup-index',compact('data'));
    }

    public function create(Request $request)
    {
        if(check_privilege(720,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['employee_id'] = $request['to_emp_id'];

        $period = OrgCalender::query()->where('company_id',$this->company_id)
            ->where('calender_year',$request['salary_year'])
            ->where('month_id',$request['salary_month'])->first();

        $request['period_id'] = $period->id;

        DB::beginTransaction();

        try {

            Arear::query()->create($request->all());

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error',$error)->withInput();
        }

        DB::commit();

        return redirect()->action('Payroll\Salary\ArearSetupController@index')->with('success','Arear Data Added');


    }

    public function destroy(Request $request)
    {
        if(check_privilege(720,4) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            $data = Arear::query()->where('id',$request['row_id'])->first();

            if($data->posted == true)
            {
                return response()->json(['error' => 'Data Already Posted To Salary. Not possible to delete'], 404);
                die();
            }


            Arear::query()->where('id',$request['row_id'])->delete();

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['success' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Arear Data Deleted','row-id' => $request['row_id']], 200);
    }
}
