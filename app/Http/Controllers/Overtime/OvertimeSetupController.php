<?php

namespace App\Http\Controllers\Overtime;

use App\Models\Overtime\OvertimeSetup;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OvertimeSetupController extends Controller
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
        if(check_privilege(51,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
        $AgoDate=Carbon::now()->subWeek(+4)->format('Y-m-d');  
        $NowDate=Carbon::now()->format('Y-m-d');  
     
      // $month_id = Carbon::now()->format('m');
  
    //dd($AgoDate);
        $dept_id = Session::get('session_user_dept_id');

        $data = OvertimeSetup::query()->whereBetween('ot_date',[$AgoDate,$NowDate])
        ->where('approval_status',false)
        ->where('status',true)
        ->whereNull('finalize_at')
        ->whereNull('finalize_by')
          ->whereHas('professional', function($q) use($dept_id) {
             $q->where('department_id', $dept_id);
                })
          ->with('professional')
          ->orderBy('ot_date','desc')
        ->get();

       
          
         // dd($data);
          //  
        return view('overtime.overtime-setup-index',compact('data'));
    }

    public function create(Request $request)
    {
        if(check_privilege(51,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['ot_date'] = Carbon::createFromFormat('d-m-Y',$request['ot_date'])->format('Y-m-d');

        $request['employee_id'] = $request['to_emp_id'];
        $request['exit_date'] = Carbon::createFromFormat('d-m-Y H:i',$request['exit_time'])->format('Y-m-d');
        $request['exit_time'] = Carbon::createFromFormat('d-m-Y H:i',$request['exit_time'])->format('H:i');


        $personald = EmpProfessional::query()
            ->select('emp_personals_id')
            ->where('employee_id',$request['employee_id'])
             ->first();

         $leaves = LeaveApplication::query()
            ->where('company_id',$this->company_id)
            ->where('status','A')
            ->where('duty_date',$request['ot_date'])
             ->where('emp_personals_id',$personald->emp_personals_id)
            ->first();
      
        // dd($leaves);

        if(empty($leaves)) {

            DB::beginTransaction();

            try {

                OvertimeSetup::query()->create($request->all());


            } catch (\Exception $e) {
                DB::rollBack();
                $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
                return redirect()->back()->with('error', $error)->withInput();
            }

            DB::commit();
            return redirect()->action('Overtime\OvertimeSetupController@index')->with('success','Overtime Data Added');
        }
        else{

            return redirect()->action('Overtime\OvertimeSetupController@index')->with('error','You already apply for leave on that date!!');
        }
    }


    public function delete(Request $request)
    {

        if(check_privilege(51,4) == false) //2=show Division  1=view
        {
//            return redirect()->back()->with('error', trans('message.permission'));
            return response()->json(['error' => 'You Do Not Have Permission'], 404);
            die();
        }



        DB::beginTransaction();

        try {

            $data = OvertimeSetup::query()->where('id',$request['row_id'])->first();

            if($data->approval_status==true)
            {
                return response()->json(['error' => 'Data Already Approved. Not possible to delete'], 404);
                die();
            }


            OvertimeSetup::query()->where('id',$request['row_id'])->delete();



        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['success' => $error], 404);
        }

        DB::commit();




        return response()->json(['success' => 'Overtime Data Deleted','row-id' => $request['row_id']], 200);
    }
}
