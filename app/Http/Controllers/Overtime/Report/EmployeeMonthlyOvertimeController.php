<?php

namespace App\Http\Controllers\Overtime\Report;

use App\Exports\OvertimeSetupExport;
use App\Models\Common\Department;
use App\Models\Attendance\DailyAttendance;
use App\Models\Overtime\OvertimeSetup;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeMonthlyOvertimeController extends Controller
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

        if (check_privilege(53, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }       

        return view('overtime.report.employee_monthly-overtime-index');
    }

    
}
