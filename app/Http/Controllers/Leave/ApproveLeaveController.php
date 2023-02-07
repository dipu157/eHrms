<?php

namespace App\Http\Controllers\Leave;

use App\Models\Attendance\DailyAttendance;
use App\Models\Attendance\PunchDetail;
use App\Models\Leaves\LeaveApplication;
use App\Models\Leaves\LeaveRegister;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ApproveLeaveController extends Controller
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
        if(check_privilege(31,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('leave.index.approve-leave-index');
    }


    public function approveData()
    {
        $leaves = LeaveApplication::query()->where('company_id',1)
            ->with('personal')->with('type')
//            ->where('leave_id',3)
            ->where('status','R')->get();


        return DataTables::of($leaves)

            ->addColumn('action', function ($leaves) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="approve/view/'.$leaves->id.'"  type="button" class="btn btn-info btn-view btn-sm"><i class="fa fa-folder-open">View</i></button>
                    <button data-remote="approve/'.$leaves->id.'"  type="button" class="btn btn-primary btn-approve btn-sm"><i class="fa fa-folder-open">Approve</i></button>
                    <button data-remote="approve/reject/'.$leaves->id.'"  type="button" class="btn btn-secondary btn-reject btn-sm"><i class="fa fa-folder-open">Reject</i></button>
                    </div>
                    
                    ';
            })

            ->editColumn('image', function ($leaves) {
                if (!isset($leaves->personal->photo)) {
                    return '<img src="' . asset("assets/images/male.jpeg") .
                        '" alt=" " style="height: 30px; width: 50px;" >';
                }
                return '<img src="' . asset($leaves->personal->photo) .
                    '" alt=" " style="height: 30px; width: 50px;" >';
            })

            ->addColumn('leave_date', function ($leaves) {


                return Carbon::parse($leaves->from_date)->format('d-m-Y') . " To " . Carbon::parse($leaves->to_date)->format('d-m-Y');

            })


            ->addColumn('status', function ($leaves) {

                return $leaves->status == true ? 'Active' : 'Disabled';
            })

            ->addColumn('leave_type', function ($leaves) {

                $punchs = DailyAttendance::query()->where('employee_id',$leaves->professional->employee_id)
                    ->where('attend_date',$leaves->duty_date)->first();

                if(!empty($punchs))
                {
                    return $leaves->leave_id == 3 ? $leaves->type->name. '<br/> <span style="color: #0c5460">' .$leaves->duty_date . '<br/> <button type="button" data-toggle="modal" data-target="#punchInfoModalSuccess'.$leaves->id.'" class="btn btn-info btn-punch btn-sm">Punch</button>

                        <div class="modal fade" id="punchInfoModalSuccess'.$leaves->id.'" tabindex="-1" role="dialog" aria-labelledby="punchInfoModalSuccessLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-notify modal-info" role="document">
                                <!--Content-->
                                <div class="modal-content">
                                    <!--Header-->
                                    <div class="modal-header">
                                        <p class="heading lead">Modal Success</p>
                        
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="white-text">&times;</span>
                                        </button>
                                    </div>
                        
                                    <!--Body-->
                                    <div class="modal-body">
                        
                                        <table class="table table-bordered" id="punch_table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Entry Time</th>
                                                    <th>Exit Time</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                             <tr>
                                                <td>'. $punchs->employee_id .'</td>
                                                <td>'.Carbon::parse($leaves->duty_date)->format('d-m-Y') .'</td>
                                                <td>'.Carbon::parse($punchs->entry_time)->format('g:i A').'</td>
                                                <td>'.Carbon::parse($punchs->exit_time)->format('g:i A').'</td>
                        
                                            </tr>
                                            </tbody>
                        
                                        </table>
                                    </div>
                        
                                    <!--Footer-->
                                    <div class="modal-footer justify-content-center">
                                        <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Thanks</a>
                                    </div>
                                </div>
                                <!--/.Content-->
                            </div>
                        </div>
                        <!-- Central Modal Medium Success-->
                ' : $leaves->type->name .'</span>';
                }else
                {

                    return $leaves->leave_id == 3 ? $leaves->type->name. '<br/> <span style="color: #0c5460">' .$leaves->duty_date . '<br/> <button type="button" data-toggle="modal" data-target="#punchInfoModalSuccessN'.$leaves->id.'" class="btn btn-info btn-punch btn-sm">Punch</button>

                        <div class="modal fade" id="punchInfoModalSuccessN'.$leaves->id.'" tabindex="-1" role="dialog" aria-labelledby="punchInfoModalSuccessLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-notify modal-info" role="document">
                                <!--Content-->
                                <div class="modal-content">
                                    <!--Header-->
                                    <div class="modal-header">
                                        <p class="heading lead">Modal Success</p>
                        
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="white-text">&times;</span>
                                        </button>
                                    </div>
                        
                                    <!--Body-->
                                    <div class="modal-body">
                        
                                        <table class="table table-bordered" id="punch_table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Entry Time</th>
                                                    <th>Exit Time</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                             <tr>
                                                <td>'. $leaves->professional->employee_id .'</td>
                                                <td>No Data</td>
                                                <td>No Data</td>
                                                <td>No Data</td>
                        
                                            </tr>
                                            </tbody>
                        
                                        </table>
                                    </div>
                        
                                    <!--Footer-->
                                    <div class="modal-footer justify-content-center">
                                        <a type="button" class="btn btn-outline-success waves-effect" data-dismiss="modal">Thanks</a>
                                    </div>
                                </div>
                                <!--/.Content-->
                            </div>
                        </div>
                        <!-- Central Modal Medium Success-->
                ' : $leaves->type->name .'</span>';

                }

            })

            ->rawColumns(['action','status','image','leave_date','leave_type'])
            ->make(true);
    }

    public function view($id)
    {
        $c_year = date("Y");

        $emp_info = LeaveApplication::query()->where('id',$id)
            ->with('personal')->with('type')->with('alternate')
            ->first();

           // dd($emp_info);

        $leaves = LeaveApplication::query()->where('company_id',$this->company_id)
            ->where('emp_personals_id',$emp_info->emp_personals_id)
            ->where('status','A')
            ->get();

        return view('leave.view.view-leave-status',compact('emp_info','leaves','c_year'));
    }

    public function approve($id)
    {

//        dd($id);
        if(check_privilege(31,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {



            $leave_data = LeaveApplication::query()->where('id',$id)->first();

            $days = dateDifference($leave_data->from_date, $leave_data->to_date);
            $nod = $days+1;

            $dates = createDateRange($leave_data->from_date, getNextDay($leave_data->to_date));


            LeaveRegister::query()->where('company_id',$this->company_id)
                ->where('emp_personals_id',$leave_data->emp_personals_id)
                ->where('leave_year',$leave_data->leave_year)
                ->where('leave_id',$leave_data->leave_id)
                ->increment('leave_enjoyed',$nod);

            if(($leave_data->leave_id == 1) OR ($leave_data->leave_id == 2) OR ($leave_data->leave_id == 4))
            {
                LeaveRegister::query()->where('company_id',$this->company_id)
                    ->where('emp_personals_id',$leave_data->emp_personals_id)
                    ->where('leave_year',$leave_data->leave_year)
                    ->where('leave_id',$leave_data->leave_id)
                    ->decrement('leave_balance',$nod);
            }

            LeaveApplication::query()->where('id',$id)->update(['approver_id'=>$this->user_id,'approve_date'=>Carbon::now(),'status'=>'A']);

            if($leave_data->leave_id == 3)
            {
                DailyAttendance::query()->where('employee_id',$leave_data->professional->employee_id)
                    ->where('attend_date',$leave_data->duty_date)->where('attend_status','P')
                    ->update(['alter_leave_date'=>$leave_data->from_date,'compensate'=>'L']);
            }

            foreach ($dates as $dt)
            {
                DailyAttendance::query()->where('company_id',$this->company_id)
                    ->where('employee_id',$leave_data->professional->employee_id)
                    ->where('attend_date',$dt)
                    ->update(['leave_flag'=>true,'leave_id'=>$leave_data->leave_id,'holiday_flag'=>false,'offday_flag'=>false]);
            }


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Leave has been Approved'], 200);
    }


    public function reject($id)
    {

        if(check_privilege(31,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        dd($id);
        DB::beginTransaction();

        try {

            LeaveApplication::query()->where('id',$id)->update(['approver_id'=>$this->user_id,'approve_date'=>Carbon::now(),'status'=>'D','notes'=>'Rejected By Approver']);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Leave has been recommended for approval'], 200);
    }
}
