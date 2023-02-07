<?php

namespace App\Http\Controllers\Attendance;

use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\PunchDetail;
use App\Models\Common\CommonLog;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveApplication;
use App\Models\Leaves\LeaveMaster;
use App\Models\Leaves\LeaveRegister;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateAttendanceController extends Controller
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
        if(check_privilege(36,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $leaves = LeaveMaster::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');

        return view('attendance.update-attendance-index',compact('leaves'));
    }

    public function update(Request $request)
    {

        if(check_privilege(36,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        dd($request->all());


//        $att = DailyAttendance::query()->find($request['to_id']);
        $original = DailyAttendance::query()->where('id',$request['to_id'])->first();

        $attend_date = Carbon::createFromFormat('d-m-Y',$request['att_date'])->format('Y-m-d');


        $emp_prof = EmpProfessional::query()->where('company_id',$this->company_id)
            ->where('employee_id',$original->employee_id)->first();


        DB::beginTransaction();

        try {

            // LAte Aloww

            if($request->filled('late_allow'))
            {

                $request['company_id'] = $this->company_id;
                $request['usecase_id'] = 36;
                $request['entry_type'] = 'E';
                $request['table_name'] = 'daily_attendances';
                $request['old_data'] = implode($original->toArray(),' : ');
                $request['new_data'] = 'Updated';
                $request['user_ip'] = $request->ip();
                $request['user_id'] = $this->user_id;
                $request['description'] = $request['reason'];
                CommonLog::query()->create($request->all());

                DailyAttendance::query()->where('id',$request['to_id'])
                    ->update(['late_flag'=>false,'late_allow'=>true,'late_minute'=>0,'manual_update'=>true]);


                PunchDetail::query()->where('employee_id',$emp_prof->employee_id)
                    ->whereDate('attendance_datetime',$original->attend_date)
                    ->update(['late_allow'=>true]);

            }

            // Leave Related Changes

            if ($request->filled('leave_id') && $original->leave_flag == false) {

                $request['company_id'] = $this->company_id;
                $request['leave_year'] = Carbon::createFromFormat('d-m-Y', $request['att_date'])->format('Y');
                $request['emp_personals_id'] = $emp_prof->emp_personals_id;
                $request['from_date'] = Carbon::createFromFormat('d-m-Y', $request['att_date'])->format('Y-m-d');
                $request['to_date'] = Carbon::createFromFormat('d-m-Y', $request['att_date'])->format('Y-m-d');
                $request['nods'] = 1;
                $request['application_time'] = 'A';
                $request['location'] = 'Force Leave';
                $request['alternate_id'] = null;
                $request['status'] = 'A';
                $request['user_id'] = $this->user_id;
                $request['approver_id'] = $this->user_id;
                $request['approve_date'] = Carbon::now();
                $request['recommend_id'] = $this->user_id;
                $request['recommend_date'] = Carbon::now();
                $request['usecase_id'] = 36;
                $request['entry_type'] = 'E';
                $request['table_name'] = 'daily_attendances';
                $request['old_data'] = implode($original->toArray(),' : ');
                $request['new_data'] = 'Updated';
                $request['user_ip'] = $request->ip();
                $request['user_id'] = $this->user_id;
                $request['description'] = $request['reason'];
                CommonLog::query()->create($request->all());

                LeaveApplication::query()->create($request->all());

                LeaveRegister::query()->where('emp_personals_id',$emp_prof->emp_personals_id)
                    ->where('company_id',$this->company_id)
                    ->where('leave_id',$request['leave_id'])
                    ->increment('leave_enjoyed',1);

                $original->update(['leave_flag' => true, 'leave_id'=>9, 'manual_update' => true, 'manual_updated_by' => $this->user_id, 'manual_update_remarks' => $request['reason']]);

            }


//            if($request->filled('late_allow'))
//            {
//                $att->update(['late_allow'=>true,'manual_update' => true, 'manual_updated_by' => $this->user_id, 'manual_update_remarks' => $request['reason']]);
//            }
//
//            if($request->filled('overtime_hour'))
//            {
//                $att->update(['over_time'=>true,'overtime_hour'=>$request['overtime_hour'],'manual_update' => true, 'manual_updated_by' => $this->user_id, 'manual_update_remarks' => $request['reason']]);
//            }


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error)->withInput();
        }

        DB::commit();
        
        
        return redirect()->action('Attendance\UpdateAttendanceController@index')->with('success','Attendance Data Successfully Modified');
    }
}
