<?php

namespace App\Http\Controllers\Leave;

use App\Models\Leaves\LeaveApplication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PendingLeaveController extends Controller
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
//        if(check_privilege(28,1) == false) //2=show Division  1=view
//        {
//            return redirect()->back()->with('error', trans('message.permission'));
//            die();
//        }

//        dd('here');

        $data = LeaveApplication::query()->where('company_id',$this->company_id)
            ->whereIn('status',['C','K','R'])
            ->with('professional')
            ->orderBy('from_date','ASC')
            ->get();

        $departments = $data->unique('professional.department_id');

        return view('leave.report.pending-leave-index',compact('data','departments'));
    }
}
