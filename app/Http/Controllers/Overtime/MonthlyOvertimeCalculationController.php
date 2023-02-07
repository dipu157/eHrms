<?php

namespace App\Http\Controllers\Overtime;

use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\PunchDetail;
use App\Models\Common\Department;
use App\Models\Overtime\OvertimeSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonthlyOvertimeCalculationController extends Controller
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
        if(check_privilege(54,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->orderBy('name')
            ->pluck('name','id');

        $dateRange = null;
        $department = null;

        if($request->has('department_id'))
        {
            $from = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
            $todate = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');

            $dept_id = $request['department_id'];
            $department = Department::query()->where('company_id',$this->company_id)
                ->where('id',$dept_id)->first();

            $dateRange = createDateRange($from,getNextDay($todate));

//            dd($dates);

            $data = OvertimeSetup::query()->where('company_id',$this->company_id)
                ->whereHas('professional', function ($q) use($dept_id){
                    $q->where('department_id',$dept_id);
                })
                ->whereBetween('ot_date',[$from,$todate])
                ->where('actual_overtime_hour',0)
                ->where('approval_status',true)->where('status',true) // Status 0 is rejected
                ->orderBy('ot_date','employee_id','ASC')
                ->get();

            $attend = DailyAttendance::query()->where('company_id',$this->company_id)
                ->whereBetween('attend_date',[$from,$todate])
                ->where('department_id',$dept_id)->get();

            $newdata = collect();

            foreach ($attend as $day)
            {
                foreach ($data as $row)
                {
                    if(($row->ot_date == $day->attend_date) and ($row->employee_id == $day->employee_id))
                    {
                        $row['entry'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->entry_date .' '. $day->entry_time)->format('d-m-Y g:i A') : Carbon::parse($day->entry_time)->format('g:i A');
                        $row['exit'] = $day->exit_date > $day->attend_date ? Carbon::parse($day->exit_date . ' ' . $day->exit_time)->format('d-m-Y g:i A') : Carbon::parse($day->exit_time)->format('g:i A');
                        $row['shift_entry'] = $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_entry_time)->format('g:i A');
                        $row['shift_exit'] =  $day->shift_id == 1 ? 'Off Day' : Carbon::parse($day->shift_exit_time)->format('g:i A');

//                        $row['calculated_hour'] = $row->overtime_from_punch;
                        if($row->overtime_from_punch == 0)
                        {
                            $from_ot_time = strtotime($day->attend_date .' '.$day->entry_time);
                            $to_ot_time = strtotime($day->attend_date .' '.$day->shift_entry_time);

                            $overtime_hour = floor(($to_ot_time - $from_ot_time) / 3600);

                            $row['calculated_hour'] = $overtime_hour > 1 ? $overtime_hour : 0;
                        }else{
                            $row['calculated_hour'] = $row->overtime_from_punch;
                        }


                        $newdata->push($row);
                    }

                }
            }

//            dd($newdata);

//            foreach ($data as $row)
//            {
//
//            }

            return view('overtime.monthly-overtime-calculation-index',compact('departments','data','dateRange','attend','newdata','department'));
        }

        return view('overtime.monthly-overtime-calculation-index',compact('departments','dateRange'));
    }

    public function update(Request $request)
    {

        if(check_privilege(54,1) == false) //2=show Division  1=view
        {
            return response()->json(['error' => trans('message.permission')], 404);

//            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
      
        $data = OvertimeSetup::query()->where('id',$request['row_id'])->first();

        $exist = OvertimeSetup::query()->where('ot_date',$data->ot_date)
            ->where('employee_id',$data->employee_id)->where('id','<>',$data->id)
            ->where('actual_overtime_hour','>',0)
            ->get();

//        dd($exist);

        if(count($exist) > 0)
        {
            return response()->json(['error' => 'Data Exist For The Same Employee Same Date'], 404);
        }

        DB::beginTransaction();

        try {

            OvertimeSetup::query()->find($request['row_id'])->update(['reject_Reason'=>$request['reject_Reason'],'actual_overtime_hour'=>$request['final_hour'],'finalize_at'=>Carbon::now(),'finalize_by'=>$this->user_id
            ]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();


        return response()->json(['success' => 'Overtime Data Finalized'], 200);
    }

    public function reject(Request $request)
    {
        if(check_privilege(54,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
        DB::beginTransaction();

        try {

            OvertimeSetup::query()->find($request['row_id'])->update(['reject_Reason'=>$request['reject_Reason'],'status'=> 0,
                'finalize_at'=>Carbon::now(),
                'finalize_by'=>$this->user_id
            ]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();


        return response()->json(['success' => 'Overtime Rejected'], 200);

    }

    public function getPunchData(Request $request)
    {
        $from_date = getPreviousDay($request['punch_date']);
        $to_date = getNextDay($request['punch_date']);

        $punches = PunchDetail::query()
            ->select(DB::raw('date_format(attendance_datetime,"%d/%m/%Y %l:%i:%s %p") as punch_dt'))
            ->whereBetween(DB::Raw('DATE(attendance_datetime)'),[$from_date,$to_date])
            ->where('employee_id',$request['employee_id'])->get();

//        dd($punches);

        return json_encode($punches);

//        dd($to_date);
    }
}
