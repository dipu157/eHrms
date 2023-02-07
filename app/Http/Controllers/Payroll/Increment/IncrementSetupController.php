<?php

namespace App\Http\Controllers\Payroll\Increment;

use App\Models\Common\OrgCalender;
use App\Models\Payroll\Increment;
use App\Models\Payroll\SalarySetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncrementSetupController extends Controller
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
        if(check_privilege(710,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = Increment::query()->where('company_id',$this->company_id)
            ->with('professional')
            ->orderBy('id','desc')
            ->take(10)
            ->get();

        if($request->filled('search_id'))
        {

            $data = Increment::query()->where('company_id',$this->company_id)
                ->where('employee_id',$request['search_id'])
                ->with('professional')
                ->orderBy('id','desc')
                ->get();

        }

        return view('payroll.increment.increment-setup-index',compact('data'));
    }

    public function create(Request $request)
    {
        if(check_privilege(710,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['employee_id'] = $request['to_emp_id'];
        $request['effective_from'] = Carbon::createFromFormat('d-m-Y',$request['effective_from'])->format('Y-m-d');

        $period = OrgCalender::query()->where('company_id',$this->company_id)
            ->where('calender_year',$request['salary_year'])
            ->where('month_id',$request['salary_month'])->first();

        $request['period_id'] = $period->id;

        DB::beginTransaction();

        try {

            Increment::query()->create($request->all());

            SalarySetup::query()->where('company_id',$this->company_id)
                ->where('employee_id',$request['employee_id'])
                ->update(['basic'=>$request['increased_basic']]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error',$error)->withInput();
        }

        DB::commit();

        return redirect()->action('Payroll\Increment\IncrementSetupController@index')->with('success','Arear Data Added');


    }

    public function destroy(Request $request)
    {

        if(check_privilege(710,4) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            $data = Increment::query()->where('id',$request['row_id'])->first();

//            dd($data);

            if($data->posted == true)
            {
                return response()->json(['error' => 'Data Already Posted To Salary. Not possible to delete'], 404);
                die();
            }

            $data = Increment::query()->where('id',$request['row_id'])->first();

            SalarySetup::query()->where('company_id',$this->company_id)
                ->where('employee_id',$data->employee_id)
                ->update(['basic'=>$data->previous_basic]);

            Increment::query()->where('id',$request['row_id'])->delete();


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['success' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Increment Data Deleted','row-id' => $request['row_id']], 200);
    }
}
