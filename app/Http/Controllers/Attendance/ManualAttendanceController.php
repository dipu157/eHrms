<?php

namespace App\Http\Controllers\Attendance;

use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\PunchDetail;
use App\Models\Common\CommonLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManualAttendanceController extends Controller
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
        if(check_privilege(35,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('attendance.manual-attendance-index');
    }

    public function create(Request $request)
    {
        if(check_privilege(35,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }



        $log_data = implode($request->except('_token')," , ");

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['employee_id'] = $request['to_id'];
        $att_date = Carbon::createFromFormat('d-m-Y',$request['att_date'])->format('Y-m-d');

        $att_data = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('employee_id',$request['employee_id'])
            ->where('attend_date',$att_date)->first();


        DB::beginTransaction();

        try {

            $request['device_id'] = '9999M';

            if($request->filled('entry_time'))
            {
                $request['attendance_datetime'] = Carbon::createFromFormat('d-m-Y H:i',$request['att_date'].' '.$request['entry_time'])->format('Y-m-d H:i');
                $entry = $request['attendance_datetime'];

                PunchDetail::query()->create($request->all());

//                dd($request->all());

                if(!empty($att_data))
                {
                    DailyAttendance::query()->where('company_id',$this->company_id)
                        ->where('employee_id',$request['employee_id'])
                        ->where('attend_date',$att_date)
                        ->update(
                            [
                                'attendance_datetime'=>$entry,'entry_date'=>$att_date,
                                'entry_time'=>$request['entry_time'],
                                'attend_status'=>'P',
                                'late_flag' =>false,
                                'late_minute'=>0,
                                'manual_update'=>true,
                                'manual_updated_by'=>Auth::id(),
                                'manual_update_remarks'=>$request['reason']
                            ]);
                }


            }

            if($request->filled('exit_time'))
            {
                $request['attendance_datetime'] = Carbon::createFromFormat('Y-m-d H:i',$request['exit_time'])->format('Y-m-d H:i');


                $exit_date = Carbon::createFromFormat('Y-m-d H:i',$request['exit_time'])->format('Y-m-d');
                $exit_time = Carbon::createFromFormat('Y-m-d H:i',$request['exit_time'])->format('H:i');

                PunchDetail::query()->create($request->all());

                DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('employee_id',$request['employee_id'])
                    ->where('attend_date',$att_date)
                    ->update(
                        [
                            'exit_date'=>$exit_date,
                            'exit_time'=>$exit_time,
                            'over_time' =>false,
                            'overtime_hour'=>0,
                            'manual_update'=>true,
                            'manual_updated_by'=>Auth::id(),
                            'manual_update_remarks'=>$request['reason']
                        ]);

            }

            $request['usecase_id'] = 35;
            $request['entry_type'] = 'A';
            $request['table_name'] = 'punch_details';
            $request['old_data'] = null;
            $request['new_data'] = $log_data;
            $request['description'] = 'Manually Attendance Entered';
            $request['user_ip'] = $request->ip();

            CommonLog::query()->create($request->all());

            $request['table_name'] = 'daily_attendances';
            $request['old_data'] = 'Absent';
            CommonLog::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Attendance\ManualAttendanceController@index')->with('success','Manually Attendance Data Inserted Successfully');

    }
}
