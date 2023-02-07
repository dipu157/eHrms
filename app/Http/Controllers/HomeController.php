<?php

namespace App\Http\Controllers;

use App\Models\Common\Department;
use App\Models\Common\Privilege;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Models\Leaves\LeaveApplication;
use App\Models\Notice\Notice;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $data = EmpPersonal::query()
//            ->select('user_id', DB::Raw('count(id) as noe'))
//            ->groupBy('user_id')->get();
//
//        $todays = EmpPersonal::query()
//            ->select('user_id', DB::Raw('count(id) as noe'))
////            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'),Carbon::now()->format('Y-m-d'))
//            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
//            ->groupBy('user_id')->get();

        $user = User::query()->where('id',Auth::id())->first();

        $notices = Notice::query()->where('company_id',Auth::user()->company_id)
            ->where('receiver','A')->where('type','D')
            ->where('status',true)->whereDate('expiry_date','>',Carbon::now()->format('Y-m-d'))
            ->orderBy('id','DESC')
            ->get();


        $ack_leave = LeaveApplication::query()->where('company_id',Auth::user()->company_id)
            ->where('alternate_id',Auth::user()->emp_id)
            ->where('status','C')
            ->count();

        $dept_id = Session::get('session_user_dept_id');

        $role = Privilege::query()->where('user_id',Auth::id())
            ->where('menu_id',30)->value('add');

//        dd($role);

//        $dept_id = Session::get('')

        $dept_data = Department::query()->where('id',$dept_id)->value('leave_steps');

        if($dept_data == '1111')
        {
            $rec_leave = LeaveApplication::query()->where('company_id',Auth::user()->company_id)
                ->where('status','K')
                ->get();
        }else{
            $rec_leave = LeaveApplication::query()->where('company_id',Auth::user()->company_id)
                ->whereIn('status',['C','K'])
                ->get();
        }


        $ext_dept = Department::query()->where('report_to',$user->emp_id)->first();
        $ext_dept_id = is_null($ext_dept) ? null : $ext_dept->id;

        $emp_personal = EmpProfessional::query()->where('company_id',Auth::user()->company_id)
            ->where('employee_id',$user->emp_id)->first();


        $report_to = EmpProfessional::query()->where('company_id',Auth::user()->company_id)
            ->where('report_to',$emp_personal->emp_personals_id);


        $emp_ids = EmpProfessional::query()->where('company_id',Auth::user()->company_id)
            ->whereIn('department_id',[$dept_id,$ext_dept_id])
            ->union($report_to)
            ->get();




        $rec_count = 0;

        if($role == 1)
        {
            foreach ($emp_ids as $emp)
            {
                if($rec_leave->contains('emp_personals_id',$emp->emp_personals_id))
                {
                    $rec_count ++;
                }
            }
        }

//        dd($todays);

        return view('home',compact('rec_count','ack_leave','notices','user'));
    }


}
