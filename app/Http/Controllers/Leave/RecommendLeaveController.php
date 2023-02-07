<?php

namespace App\Http\Controllers\Leave;

use App\Models\Common\Department;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class RecommendLeaveController extends Controller
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
        if(check_privilege(30,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        $user_emp_id = Auth::user()->emp_id;
//
//        $ext_dept_id = Department::query()->where('report_to',$user_emp_id)->first();
//
//        dd($ext_dept_id);

//        $dept_id = 26;
//
//        $leaves = LeaveApplication::query()->where('company_id',1)
//            ->with('personal')->with('type')->with('alternate')
//            ->whereHas('userProf',function($query) use($dept_id) {
//                $query->where('department_id',$dept_id);
//            })
//            ->where('status','C')->get();


//        $rec_leave = LeaveApplication::query()->where('company_id',Auth::user()->company_id)
//            ->where('status','C')
//            ->get()->dd();

//        dd($leaves);

        return view('leave.index.recommend-leave-index');
    }


    public function recommendData()
    {


        $dept_id = Session::get('session_user_dept_id');
        $leave_steps = Department::query()->whereId($dept_id)->first();

        $user_emp_id = Auth::user()->emp_id;
        $ext_dept = Department::query()->where('report_to',$user_emp_id)->first();
        $ext_dept_id = is_null($ext_dept) ? null : $ext_dept->id;
        $employee = EmpProfessional::query()->where('employee_id',$user_emp_id)->first();
        $emp_personal_id = $employee->emp_personals_id;


        if($leave_steps->leave_steps == '1111')
        {

            $report_to = LeaveApplication::query()->where('company_id',1)
                ->with('personal')->with('type')->with('alternate')
                ->whereHas('professional',function($query) use($emp_personal_id) {
                    $query->where('report_to',$emp_personal_id);
                })
                ->where('status','K');



            $leaves = LeaveApplication::query()->where('company_id',1)
                ->with('personal')->with('type')->with('alternate')
                ->whereHas('professional',function($query) use($dept_id,$ext_dept_id) {
                    $query->whereIn('department_id',[$dept_id,$ext_dept_id]);
                })
                ->where('status','K')
                ->union($report_to)
                ->get();
        }else{

            $report_to = LeaveApplication::query()->where('company_id',1)
                ->with('personal')->with('type')->with('alternate')
                ->whereHas('professional',function($query) use($emp_personal_id) {
                    $query->where('report_to',$emp_personal_id);
                })
                ->whereIn('status',['C','K']);


            $leaves = LeaveApplication::query()->where('company_id',1)
                ->with('personal')->with('type')->with('alternate')
                ->whereHas('professional',function($query) use($dept_id,$ext_dept_id) {
                    $query->whereIn('department_id',[$dept_id,$ext_dept_id]);
                })
                ->union($report_to)
                ->whereIn('status',['C','K'])->get();
        }

//        dd(count($leaves));

        return DataTables::of($leaves)

            ->addColumn('action', function ($leaves) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$leaves->id.'"  type="button" class="btn btn-info btn-view btn-sm"><i class="fa fa-folder-open">View</i></button>
                    <button data-remote="recommend/'.$leaves->id.'"  type="button" class="btn btn-primary btn-recommend btn-sm"><i class="fa fa-folder-open">Recommend</i></button>
                    <button data-remote="reject/'.$leaves->id.'"  type="button" class="btn btn-secondary btn-reject btn-sm"><i class="fa fa-folder-open">Reject</i></button>
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

            ->addColumn('name', function ($leaves) {

                return $leaves->personal->full_name. '<br/> <span style="color: #0c5460">' . $leaves->professional->designation->name .'</span>';
            })


            ->addColumn('leave_date', function ($leaves) {

                return Carbon::parse($leaves->from_date)->format('d-m-Y') . " To ".Carbon::parse($leaves->to_date)->format('d-m-Y') . '<br/><span style="color: #0c5460"> App Date '.  Carbon::parse($leaves->created_at)->format('d-m-Y') .'</span>';
            })
            ->addColumn('alternate', function ($leaves) {

                return $leaves->alternate->personal->full_name;
            })
            ->addColumn('status', function ($trainings) {

                return $trainings->status == true ? 'Active' : 'Disabled';
            })

            ->addColumn('leave_type', function ($leaves) {

                return $leaves->leave_id == 3 ? $leaves->type->name. '<br/> <span style="color: #0c5460">' .$leaves->duty_date : $leaves->type->name .'</span>';
            })

            ->rawColumns(['action','status','image','leave_date','alternate','leave_type','name'])
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

    public function recommend($id)
    {

        if(check_privilege(30,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            LeaveApplication::query()->where('id',$id)->update(['recommend_id'=>$this->user_id,'recommend_date'=>Carbon::now(),'status'=>'R']);


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


    public function reject($id)
    {

        if(check_privilege(30,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            LeaveApplication::query()->where('id',$id)->update(['recommend_id'=>$this->user_id,'recommend_date'=>Carbon::now(),'status'=>'D','notes'=>'Rejected By Head']);

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
