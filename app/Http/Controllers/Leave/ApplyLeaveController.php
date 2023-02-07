<?php

namespace App\Http\Controllers\Leave;

use App\Models\Common\Department;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveApplication;
use App\Models\Leaves\LeaveMaster;
use App\Models\Leaves\LeaveRegister;
use App\Models\Overtime\OvertimeSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ApplyLeaveController extends Controller
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
        if(check_privilege(29,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $c_year = date("Y");

        if(!empty($request['emp_id']))
        {
            $emp_info = EmpPersonal::query()
            ->with(['leaveStatus' => function ($query) use ($c_year) {
                    $query->where('leave_year', $c_year);
                }])
            ->with(['leave' => function ($query) use ($c_year) {
                    $query->where('leave_year', $c_year);
                }])
            ->where('id',$request['emp_id'])->first();
            $leaves = LeaveMaster::query()->where('company_id',$this->company_id)->pluck('name','id');

            $emp_leaves = LeaveMaster::query()->where('company_id',$this->company_id)->get();

            $l_year = Carbon::now()->format('Y');

            foreach ($emp_leaves as $row)
            {
                if (!LeaveRegister::query()->where('emp_personals_id', $request['emp_id'])
                    ->where('leave_id',$row->id)->where('leave_year',$l_year)
                    ->exists()) {

                    LeaveRegister::query()->insert([
                        'company_id'=>$this->company_id,
                        'emp_personals_id' =>$request['emp_id'],
                        'leave_id' =>$row['id'],
                        'leave_eligible' =>$row['yearly_limit'],
                        'leave_year'=>$l_year
                    ]);
                }
            }

            return view('leave.index.apply-leave-index',compact('emp_info','leaves'));
        }

        return view('leave.index.apply-leave-index');
    }

    public function create(Request $request)
    {

        if(check_privilege(29,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $validator = Validator::make($request->all(), [
            'from_date' => 'required',
            'to_date' => 'required',
            'alternate_id' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dept_id = Session::get('session_user_dept_id');
        $leave_steps = Department::query()->whereId($dept_id)->first();


        $request['duty_date'] =  $request['leave_id'] == 3 ? Carbon::createFromFormat('d-m-Y',$request['duty_date']) : null;
        $request['from_date']= Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
        $request['to_date'] = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] =  $leave_steps->leave_steps == '1111' ? 'C' : 'K';
        $request['emp_personals_id'] = $request['emp_id'];
        $request['nods'] = dateDifference($request['from_date'],$request['to_date']) + 1;
        $today = Carbon::now()->format('Y-m-d');
        $request['application_time'] = $request['to_date'] < $today ? 'A' : 'B';
        $request['leave_year'] = Carbon::createFromFormat('Y-m-d',$request['from_date'])->format('Y');

        $empid = EmpProfessional::query()
                    ->select('employee_id')
                    ->where('emp_personals_id',$request['emp_id'])
                    ->first();

        $otme = OvertimeSetup::query()
            ->where('company_id',$this->company_id)->where('status','1')
            ->whereDate('ot_date',$request['duty_date'])
            ->where('employee_id',$empid->employee_id)->first();

        $alt_leave_enjoy = LeaveApplication::query()
            ->where('company_id',$this->company_id)
            ->whereDate('duty_date',$request['duty_date'])
            ->where('status','A')
            ->where('emp_personals_id',$request['emp_personals_id'])->first();

        //dd($alt_leave_enjoy);



        if(empty($otme) && empty($alt_leave_enjoy)) {

        DB::beginTransaction();

        try {

            LeaveApplication::query()->create($request->all());

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();


        return redirect()->action('Leave\ApplyLeaveController@index')->with('success','Leave Application Successfully Created for Approval');
    }
    else{
        return redirect()->action('Leave\ApplyLeaveController@index')->with('error','You Already enjoyed overtime or Leave against this day.');
    }
    }

}
