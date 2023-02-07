<?php

namespace App\Http\Controllers\Leave;

use App\Models\Leaves\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AlternateAcknowledgeLeaveController extends Controller
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
        if(check_privilege(32,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('leave.index.alternate-acknowledge-index');
    }


    public function acknowledgeData()
    {

        $leaves = LeaveApplication::query()->where('company_id',1)
            ->with('personal')->with('type')
            ->where('status','C')
            ->where('alternate_id',Auth::user()->emp_id)
            ->get();


        return DataTables::of($leaves)

            ->addColumn('action', function ($leaves) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$leaves->id.'"  type="button" class="btn btn-info btn-view btn-sm"><i class="fa fa-folder-open">View</i></button>
                    <button data-remote="acknowledge/'.$leaves->id.'"  type="button" class="btn btn-primary btn-acknowledge btn-sm"><i class="fa fa-folder-open">Acknowledge</i></button>
                    <button data-remote="refuse/'.$leaves->id.'"  type="button" class="btn btn-secondary btn-reject btn-sm"><i class="fa fa-folder-open">Refuse</i></button>
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


            ->addColumn('status', function ($trainings) {

                return $trainings->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status','image','leave_date'])
            ->make(true);
    }

    public function view($id)
    {
        $c_year = date("Y");
        $emp_info = LeaveApplication::query()->where('id',$id)
            ->with('personal')->with('type')
            ->first();

        return view('leave.view.view-leave-status',compact('emp_info','c_year'));
    }

    public function acknowledge($id)
    {

        if(check_privilege(32,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            LeaveApplication::query()->where('id',$id)->update(['alternate_submit'=>Carbon::now(),'status'=>'K']);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Leave has been acknowledge by you'], 200);
    }


    public function refuse($id)
    {

        if(check_privilege(32,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            LeaveApplication::query()->where('id',$id)->update(['alternate_submit'=>Carbon::now(),'status'=>'D','notes'=>'Refused By Alternate']);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Leave has been refused by alternate'], 200);
    }
}
