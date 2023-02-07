<?php

namespace App\Http\Controllers\Leave;

use App\Models\Employee\EmpPersonal;
use App\Models\Leaves\LeaveApplication;
use App\Models\Leaves\LeaveMaster;
use App\Models\Leaves\LeaveRegister;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateLeaveController extends Controller
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
        if (check_privilege(40, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
        $leaves = LeaveMaster::query()->where('company_id',$this->company_id)->pluck('name','id');
        $c_year = date("Y");

        // dd($c_year);

        if(!empty($request['emp_id']))
        {
            $emp_info = EmpPersonal::query()->where('company_id',$this->company_id)
                ->where('id',$request['to_id'])
                ->with('leaveApp')
                ->with(['leave' => function ($query) use ($c_year) {
                    $query->where('leave_year', $c_year);
                }])
                ->first();

            $emp_info_lastYear = EmpPersonal::query()->where('company_id',$this->company_id)
                ->where('id',$request['to_id'])
                ->with('leaveApp')
                ->with(['leave' => function ($query) use ($c_year) {
                    $query->where('leave_year', $c_year-1);
                }])
                ->first();

           // dd($emp_info19);

            $leave_apps = LeaveApplication::query()
                 ->where('leave_year',$c_year)
                ->where('emp_personals_id',$request['to_id'])
                ->whereNotIn('status',['L'])
                ->orderByDesc('from_date')->get();

            $leave_apps_lastYear = LeaveApplication::query()
                 ->where('leave_year',$c_year-1)
                ->where('emp_personals_id',$request['to_id'])
                ->whereNotIn('status',['L'])
                ->orderByDesc('from_date')->get();


            return view('leave.index.update-leave-status-index',compact('emp_info','emp_info_lastYear','leaves','leave_apps','leave_apps_lastYear','c_year'));

//            dd($empdata);
        }

        return view('leave.index.update-leave-status-index',compact('leaves'));

    }

    public function update(Request $request)
    {

        if (check_privilege(40, 2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {
            LeaveRegister::query()->where('emp_personals_id',$request['employee_id'])
                ->where('leave_id',$request['leave_id'])->where('leave_year',Carbon::now()->format('Y'))
                ->update(['leave_eligible'=>$request['eligible'],
                    'leave_balance'=> DB::raw($request['eligible'].'- leave_enjoyed')
                ]);
        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        $data = LeaveRegister::query()->where('emp_personals_id',$request['employee_id'])
            ->where('leave_id',$request['leave_id'])->where('leave_year',Carbon::now()->format('Y'))
            ->first();


        return response()->json(['success' => 'Leave Data Successfully Updated','balance' => $data->leave_balance], 200);

    }

    public function addLeaveApp(Request $request)
    {

        $request['duty_date'] =  $request['leave_id'] == 3 ? Carbon::createFromFormat('d-m-Y',$request['duty_date']) : null;
        $request['from_date']= Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
        $request['to_date'] = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = 'A';
        $request['emp_personals_id'] = $request['emp_id'];
        $request['nods'] = dateDifference($request['from_date'],$request['to_date']) + 1;
        $today = Carbon::now()->format('Y-m-d');
        $request['application_time'] = $request['to_date'] < $today ? 'A' : 'B';
        $request['leave_year'] = Carbon::createFromFormat('Y-m-d',$request['from_date'])->format('Y');

        DB::beginTransaction();

        try {

            $id = LeaveApplication::query()->create($request->all());

            if(($request['leave_id'] == 1) OR ($request['leave_id'] == 2) OR ($request['leave_id'] == 4))
            {
                LeaveRegister::query()->where('company_id',$this->company_id)
                    ->where('leave_year',$request['leave_year'])
                    ->where('emp_personals_id',$request['emp_personals_id'])
                    ->where('leave_id',$request['leave_id'])
                    ->decrement('leave_balance',$request['nods']);
            }

            LeaveRegister::query()->where('company_id',$this->company_id)
                ->where('leave_year',$request['leave_year'])
                ->where('emp_personals_id',$request['emp_personals_id'])
                ->where('leave_id',$request['leave_id'])
                ->increment('leave_enjoyed',$request['nods']);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        $leaves = LeaveApplication::query()->where('id',$id->id)
            ->with('type')
            ->first();

        return json_encode($leaves);

    }

// Cancel Approved Leave

    public function cancelLeave(Request $request)
    {

        $c_year = date("Y");

        DB::beginTransaction();

        try {

            $row = LeaveApplication::query()->find($request->row_id);

            LeaveRegister::query()->where('company_id',$this->company_id)
                ->where('emp_personals_id',$row->emp_personals_id)
                ->where('leave_year',$c_year)
                ->where('leave_id',$row->leave_id)
                ->decrement('leave_enjoyed',$row->nods);

            LeaveRegister::query()->where('company_id',$this->company_id)
                ->where('emp_personals_id',$row->emp_personals_id)
                ->where('leave_year',$c_year)
                ->where('leave_id',$row->leave_id)
                ->increment('leave_balance',$row->nods);

            LeaveApplication::query()->find($request->row_id)->update([
                'status'=>'L'
            ]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Selected Date Leave has been cancelled'], 200);
    }
}