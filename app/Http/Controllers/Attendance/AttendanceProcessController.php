<?php

namespace App\Http\Controllers\Attendance;
use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\OnDuty;
use App\Models\Attendance\PublicHoliday;
use App\Models\Attendance\PunchDetail;
use App\Models\Common\LastBatchProcess;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveApplication;
use App\Models\Overtime\OvertimeSetup;
use App\Models\Roster\Roster;
use App\Models\Roster\DutyLocation;
use App\Models\Roster\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Config;
use PhpParser\Node\Expr\New_;

class AttendanceProcessController extends Controller
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

        if(check_privilege(37,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = LastBatchProcess::query()->where('usecase_id',37)
            ->orderBy('id','DESC')->take(5)->get();

        return view('attendance.attendance-process-index',compact('data'));
    }

    public function create(Request $request)
    {

        if(check_privilege(37,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $holiday = 0;

        $late_grace = $value = config('admin-settings.maximum_late_allowed');

        $process_date = Carbon::createFromFormat('d-m-Y',$request['run_date'])->format('Y-m-d');
        $year = Carbon::createFromFormat('d-m-Y',$request['run_date'])->format('Y');
        $month = Carbon::createFromFormat('d-m-Y',$request['run_date'])->format('m');
        $day = Carbon::createFromFormat('d-m-Y',$request['run_date'])->format('d');
        $fld = 'day_'.$day;
        $day = date('D', strtotime($process_date)) == 'Fri' ? 1 : 0;

        $public_hday = PublicHoliday::query()->where('company_id',$this->company_id)->where('status',true)->get();

        $m_shift = Shift::query()->where('session_id','M')->get();

        $Of_shift = Shift::query()->where('session_id','O')->get();

//        dd($m_shift);

//        dd($process_date == Carbon::now()->format('Y-m-d') ? 'Today' : 'Back Day');



        foreach ($public_hday as $pday)
        {
            if(checkDateExistBetweenTwoDate($pday->from_date, $pday->to_date,$process_date) == true)
            {
                $holiday = 1;
            }
        }


        $leaves = LeaveApplication::query()->where('company_id',$this->company_id)->where('status','A')
            ->where('leave_year',$year)
            ->whereRaw('"'.$process_date.'" between `from_date` and `to_date`')
            ->get();


        $onduty = OnDuty::query()->where('company_id',$this->company_id)
            ->where('duty_year',$year)
            ->whereRaw('"'.$process_date.'" between `from_date` and `to_date`')
            ->get();

//        dd($onduty);



        // $emp_list = EmpProfessional::query()->where('company_id',$this->company_id)
        //     ->whereIn('working_status_id',[1,2,8])//->where('employee_id',5181486)
        //     ->where('joining_date','<=',$process_date)
        //     ->get();

        $emp_list = EmpProfessional::query()->where('company_id',$this->company_id)
            ->whereIn('working_status_id',[1,2,3,8])//->where('employee_id',5181486)
            ->where('joining_date','<=',$process_date)
            // ->orWhere(function ($query) use($process_date) {
            //     $query->whereIn('working_status_id',[3,4,5,6,7,9,10,11])->where('status_change_date','>',$process_date); })
            ->get();

        $punches = PunchDetail::query()
            ->select('id','late_allow','employee_id','device_id',DB::raw('DATE_FORMAT(attendance_datetime, "%Y-%m-%d") as att_date'),
                DB::raw('DATE_FORMAT(attendance_datetime, "%H:%i") as att_time'),
                'attendance_datetime')//->where('employee_id',5181486)
            ->where('company_id',$this->company_id)
            ->where(DB::raw('DATE_FORMAT(attendance_datetime, "%Y-%m-%d")'),$process_date)
            ->get();

//        dd($punches);

        $roster = Roster::query()->where('company_id',$this->company_id)
            ->where('r_year',$year)->where('month_id',$month) ->get();

          $shifts = Shift::query()
            ->where('company_id',$this->company_id)->get();

            $location = DutyLocation::query()
            ->where('company_id',$this->company_id)->get();
        
            // Check previous day was night duty

        $p_day_att = DailyAttendance::query()->where('company_id',$this->company_id)
            ->select('employee_id')
            ->where('attend_date',getPreviousDay($process_date))
            ->where('night_duty',true)//->where('employee_id',5181486)
            ->where('attend_status','P')
            ->get();

         $pre_ofday_att = DailyAttendance::query()->where('company_id',$this->company_id)
            ->where('attend_date',getPreviousDay($process_date))
            ->where('leave_flag',false)
            ->where('offday_flag',false)
            ->where('holiday_flag',false)
            ->where('attend_status','A')
            ->get();

        $after_ofday_att = DailyAttendance::query()->where('company_id',$this->company_id)
             ->where('attend_date',getNextDay($process_date))
            ->where('leave_flag',false)
            ->where('offday_flag',false)
            ->where('holiday_flag',false)           
            ->where('attend_status','A')
            ->get();


    // REMOVE PUCH DATA FROM COLLECTION HAS PREVIOUS DAY NIGHT DUTY

        $selected = [];

        foreach ($punches as $key => $p_data)
        {

            if(($p_day_att->contains('employee_id',$p_data->employee_id) AND $p_data->att_time < '12:00'))
            {

                $selected[] = $punches->pull($key);

            }
        }

// END REMOVE

        DB::beginTransaction();

        try {

            $overtime_hour = 0;

            foreach ($selected as $n_exit)
            {
                // set exit time for previous day night duty staffs

                $affected = DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('attend_date',getPreviousDay($process_date))
                    ->where('employee_id',$n_exit->employee_id)->first();

                $affected->update(['exit_date'=>$process_date,'exit_time'=>$n_exit->att_time]);

                $from_ot_time = strtotime($process_date .' '.$affected->shift_exit_time);
                $to_ot_time = strtotime($process_date .' '.$affected->exit_time);

                $overtime_hour = floor(($to_ot_time - $from_ot_time) / 3600);

                $overtime_hour = $overtime_hour > 1 ? $overtime_hour : 0;

                $overtime_hour > 1 ? $affected->update(['overtime_hour'=>$overtime_hour,'over_time'=>true]) : null;


                $overtime_hour = 0;


//                DailyAttendance::query()->where('company_id',$this->company_id)
//                    ->where('attend_date',getPreviousDay($process_date))
//                    ->where('employee_id',$n_exit->employee_id)
//                    ->update(['exit_date'=>$process_date,'exit_time'=>$n_exit->att_time]);



            }



            DailyAttendance::query()
                ->where('company_id',$this->company_id)
                //->whereIn('working_status_id',[1,2,8])
                ->where('attend_date',$process_date)->delete();

                //dd($roster);

            foreach ($emp_list as $item)
            {


                $leave_flag = 0;
                $leave_id = 0;

                if($leaves->contains('emp_personals_id', $item->emp_personals_id))
                {
                    $leave_flag = 0;
                    $leave_id = $leaves->where('emp_personals_id',$item->emp_personals_id)->first();

//                    dd($item->emp_personals_id);

                    foreach ($leaves as $leave)
                    {
                        if(checkDateExistBetweenTwoDate($leave->from_date, $leave->to_date,$process_date) == true)
                        {
                            $leave_flag = 1;

                        }


                    }

                }


                // Check On Duty Employee

                $od_flag = 0;

                if($onduty->contains('employee_id',$item->employee_id))
                {
                    $od_flag = 1;
                }

                $emp_roster = null;

                if ($roster->contains('employee_id', $item->employee_id))
                {
                    $emp_roster = $roster->where('employee_id',$item->employee_id)->first();
                }

//                dd($emp_roster->{$fld});

                //if roster not entered

                $locatio =null;
                if(!empty($emp_roster))
                {

                    // Get Employee Shift Details

                    $shift_g = $shifts->where('id',2)->first(); // set defult shift as general

                    if($shifts->where('company_id',$this->company_id)->where('id',$emp_roster->{$fld}))
                    {
                        $shift = $shifts->where('id',$emp_roster->{$fld})->first();

                        // if SHIFT is null or not given the

                        // if day = friday then off day otherwise general

                        if(empty($shift))
                        {
                            $shift = $day == 1 ? $shifts->where('id',1)->first() : $shifts->where('id',2)->first();
                        }
                    }

///////location

            if($location->where('company_id',$this->company_id)->where('id',$emp_roster->loc_05))
            {
                $locatio = $location->where('id',$emp_roster->loc_05)->first();

               //locat
             
               
            }

                    $entry_data =  $punches->where('employee_id',$item->employee_id)->first();


                    // Late Count

                    $late = 0;

                    if(isset($entry_data->attendance_datetime) and $entry_data->late_allow == false)
                    {
                        $to_time = strtotime($entry_data->attendance_datetime);
                        $from_time = strtotime($process_date .' '.$shift->from_time);

                        $late =  round(($to_time - $from_time) / 60,0);

                    }

                    $late_flag = $late > $late_grace ? 1 : 0;
                    $late = $late > $late_grace ? $late : 0;



                    // END LATE COUNT


                    // Sometimes Punch Infor Table not sync so need to get max punch data manualy

                    $exit =  $punches->where('employee_id',$item->employee_id)->max('attendance_datetime');

                    $exit_data = $punches->where('employee_id',$item->employee_id)->where('attendance_datetime',$exit)->first();



//                    $att_status = isset($entry_data->attendance_datetime) && $leave_flag == 0  ? 'P' : (($item->punch_exempt == true) && ($leave_flag == 0 ) && ($holiday == false) ? 'P' : 'A'),


                    ////

//                    dd($exit_data);

                    $id = DailyAttendance::query()->insertGetId([
                        'company_id' =>$this->company_id,
                        'device_id' =>'000000',
                        'employee_id' =>$item->employee_id,
                        'department_id'=>isset($item->department_id) ? $item->department_id : 1,
                        'attend_date' =>$process_date,
                        'attendance_datetime' =>isset($entry_data->attendance_datetime) ? $entry_data->attendance_datetime : null,
                        'entry_date' =>isset($entry_data->att_date) ? $entry_data->att_date : null,
                        'entry_time' =>isset($entry_data->att_time) ? $entry_data->att_time : null,
                        'shift_entry_time' =>isset($shift->from_time) ? $shift->from_time : $shift_g->from_time,
                        'exit_date' => isset($exit_data->att_date) ? $exit_data->att_date : null,
                        'exit_time' => isset($exit_data->att_time) ? $exit_data->att_time : null,
                        'shift_exit_time' =>isset($shift->to_time) ? $shift->to_time : $shift_g->to_time,
                        'attend_status' =>isset($entry_data->attendance_datetime) && $leave_flag == 0  ? 'P' : (($item->punch_exempt == true) && ($leave_flag == 0 ) && ($holiday == false) ? 'P' : 'A'),
                        'night_duty'=>isset($shift->end_next_day) ? $shift->end_next_day : $shift_g->end_next_day,
                        'offday_flag'=>$shift->id == 1 ? true : false,
                        'leave_flag' =>$leave_flag > 0 ? true : false,
                        'leave_id' =>$leave_flag > 0 ? $leave_id->leave_id : 0,
                        'holiday_flag' =>$holiday == 1 ? true : false,
                        'late_flag'=>$late_flag,
                        'late_minute'=>$late,
                        'shift_id'=>isset($shift->id) ? $shift->id : $shift_g->id,
                        'location_id'=>isset($locatio->id) ? $locatio->id :$locatio,
                        'in_process'=>true,
                        'user_id'=>Auth::id(),
                    ]);

                    // Delete Default Exit Time for Night Duty Officials
                    if($shift->end_next_day == true)
                    {
                        DailyAttendance::query()->find($id)->update(['exit_time'=>null]);
                    }

                    $leave_flag = 0;

                }else{

                    // Assume General Duty


                    $entry_data =  $punches->where('employee_id',$item->employee_id)->first();


                    $exit =  $punches->where('employee_id',$item->employee_id)->max('attendance_datetime');

                    $exit_data = $punches->where('employee_id',$item->employee_id)->where('attendance_datetime',$exit)->first();



//                    dd($entry_data);


    $locatio = 2;


                    $shift = $day == 1 ? $shifts->where('id',1)->first() : $shifts->where('id',2)->first();

                    // CALCULATE LATE

                    $late = 0;

                    if(isset($entry_data->attendance_datetime) and $entry_data->late_allow == false)
                    {
                        $to_time = strtotime($entry_data->attendance_datetime);
                        $from_time = strtotime($process_date .' '.$shift->from_time);

                        $late =  round(($to_time - $from_time) / 60,0);

                    }

                    $late_flag = $late > $late_grace ? 1 : 0;
                    $late = $late > $late_grace ? $late : 0;



                    //END LATE CALCULATION

                    $id = DailyAttendance::query()->insertGetId([
                        'company_id' =>$this->company_id,
                        'device_id' =>'000000',
                        'employee_id' =>$item->employee_id,
                        'department_id'=>isset($item->department_id) ? $item->department_id : 1,
                        'attend_date' =>$process_date,
                        'attendance_datetime' =>isset($entry_data->attendance_datetime) ? $entry_data->attendance_datetime : null,
                        'entry_date' =>isset($entry_data->att_date) ? $entry_data->att_date : null,
                        'entry_time' =>isset($entry_data->att_time) ? $entry_data->att_time : null,
                        'shift_entry_time' =>$shift->from_time,
                        'exit_date' => isset($exit_data->att_date) ? $exit_data->att_date : null,
                        'exit_time' => isset($exit_data->att_time) ? $exit_data->att_time : null,
                        'shift_exit_time' =>$shift->to_time,
                        'attend_status' => isset($entry_data->attendance_datetime) && $leave_flag == 0  ? 'P' : (($item->punch_exempt == true) && ($leave_flag == 0 ) && ($holiday == false) ? 'P' : 'A'),
//                        'attend_status' =>isset($entry_data->attendance_datetime) && $leave_flag == 0 ? 'P' : ($item->punch_exempt == true ? 'E' : 'A'),
                        'night_duty'=>false,
                        'offday_flag'=>$day, //need check friday
                        'leave_flag' =>$leave_flag > 0 ? true : false,
                        'leave_id' =>$leave_flag > 0 ? $leave_id->leave_id : 0,
                        'holiday_flag' =>$holiday == 1 ? true : false,
                        'late_flag'=>$late_flag,
                        'late_minute'=>$late,
                        'shift_id'=>$shift->id,
                        'location_id'=>isset($locatio->id) ? $locatio->id :$locatio,
                        'in_process'=>true,
                        'user_id'=>Auth::id(),
                    ]);

                    $leave_flag = 0;

                }

                // Calculate overtime for current date

                $current_id = DailyAttendance::query()->find($id);

                $from_ot_time = strtotime($process_date .' '.$current_id->shift_exit_time);

                if($current_id->shift_id == 1)
                {
                    $from_ot_time = strtotime($process_date .' '.$current_id->entry_time);
                }


                $to_ot_time = strtotime($process_date .' '.$current_id->exit_time);

                $overtime_hour = floor(($to_ot_time - $from_ot_time) / 3600);

                $overtime_hour = $overtime_hour > 1 ? $overtime_hour : 0;
                $overtime_hour > 0 ? $current_id->update(['overtime_hour'=>$overtime_hour,'over_time'=>true]) : null;

                // Make Present for on duty employee
                $od_flag == 1 ? $current_id->update(['attend_status'=>'P','manual_update_remarks'=>'Present On Duty']) : null;

                // late make false if off day duty

                $current_id->offday_flag == true ? $current_id->update(['late_flag'=>false, 'late_minute'=>0]) : null;
                
                //Late Exempt
                $item->late_exempt == true  ? $current_id->update(['late_flag'=>false,'late_allow'=>true, 'late_minute'=>0]) : null;

                // Make Off day for Punch Exempted Employee
                $item->punch_exempt == true && $current_id->offday_flag == true ? $current_id->update(['attend_status'=>'A']) : null;




                if($process_date == Carbon::now()->format('Y-m-d'))
                {
                    $right_now = Carbon::now()->format('H:i');

                    if($current_id->shift_entry_time > $right_now)
                    {
                        DailyAttendance::query()->find($id)
                            ->update(['attend_status'=>'R']);
                    }

                }

                // Check for Previous day night and continue morning duty


                if($m_shift->contains('id',$current_id->shift_id) && $current_id->attend_status=='P')
                {

                    if($p_day_att->contains('employee_id',$current_id->employee_id))
                    {

                        DailyAttendance::query()->where('id',$current_id->id)->update(['entry_time'=>$current_id->shift_entry_time,'late_flag'=>false,'late_minute'=>0]);

                    }
                }

                if(!empty($after_ofday_att))
                {
    
                    if($Of_shift->contains('id',$current_id->shift_id) && $current_id->attend_status=='A' && $current_id->offday_flag ==1 )
                    {
    
                        if($pre_ofday_att->contains('employee_id',$current_id->employee_id) && $after_ofday_att->contains('employee_id',$current_id->employee_id))
                        {
    
                            DailyAttendance::query()->where('id',$current_id->id)->update(['offday_flag'=>false]);
    
                        }
                    }

                    if($current_id->attend_status=='A' && $current_id->holiday_flag ==1 )
                    {
    
                        if($pre_ofday_att->contains('employee_id',$current_id->employee_id) && $after_ofday_att->contains('employee_id',$current_id->employee_id))
                        {
    
                            DailyAttendance::query()->where('id',$current_id->id)->update(['holiday_flag'=>false]);
    
                        }
                    }
                }



// Update Over time Setup table
                OvertimeSetup::query()->where('employee_id',$item->employee_id)
                    ->where('company_id',$this->company_id)
                    ->where('ot_date',$process_date)
                    ->update(['overtime_from_punch'=>$overtime_hour]);

//                $overtime_hour = 0;

            }


            LastBatchProcess::query()->insert([
                'company_id' => $this->company_id,
                'usecase_id' => 37,
                'process_name'=>'Attendance Process',
                'process_date_param' => $process_date,
                'user_ip'=>$request->ip(),
                'user_id'=>$this->user_id
            ]);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error' , $item->employee_id." : " . $error);
        }

        DB::commit();

        return redirect()->action('Attendance\AttendanceProcessController@index')->with(['success' => 'Attendance Process Completed :'.$process_date]);

    }
}
