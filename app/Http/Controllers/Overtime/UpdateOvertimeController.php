<?php

namespace App\Http\Controllers\Overtime;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UpdateOvertimeController extends Controller
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
        if(check_privilege(51,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        $month_id = Carbon::now()->format('m');

        $dept_id = Session::get('session_user_dept_id');



//        $data = OvertimeSetup::query()->whereMonth('ot_date',$month_id)
//            ->where('approval_status',false)
//            ->with('professional')
//            ->whereHas('professional', function($q) use($dept_id) {
//                $q->where('department_id', $dept_id);
//            })
//            ->orderBy('ot_date')
//            ->get();

        return view('overtime.overtime-update-index',compact('data'));
    }
}
