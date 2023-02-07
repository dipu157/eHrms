<?php

namespace App\Http\Controllers;

use App\Models\Company\Bangladesh;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Models\External\Biodata\BiodataCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AutoComplete extends Controller
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

    public function employee(Request $request)
    {
        $term = $request['query'];

//        $items = EmpProfessional::query()->select('id','employee_id')
//            ->where('company_id',$this->company_id)
//            ->where('employee_id', 'LIKE', '%'.$term.'%')
//            ->get();

        $items = EmpPersonal::select('id','full_name')
            ->where('company_id',$this->company_id)
            ->where('full_name', 'LIKE', '%'.$term.'%')
            ->with('professional')->get();

        return response()->json($items);
    }

    public function postCode($id)
    {
        $postCode = Bangladesh::query()->Select(DB::raw('CONCAT(post_code, " :: ", post_office, " :: ", thana) AS name'), 'post_code')
            ->where('lang','en')
            ->where('district',$id)
            ->pluck('name','post_code');

        return json_encode($postCode);
    }

    public function employeeForRoster(Request $request)
    {

        $term = $request['query'];

        if((get_user_role_id($this->user_id) == 1) or (Auth::user()->role = 2))
        {
            $items = EmpPersonal::query()->where('company_id',$this->company_id)
                ->where('full_name', 'LIKE', '%'.$term.'%')
                ->with('professional')
                ->orWhereHas('professional', function($q) use($term) {
                    $q->where('employee_id', 'LIKE',"%$term%");
                })
                ->get();
        }else{

            $emp_id = Auth::user()->emp_id;
            $dept_id = EmpProfessional::query()->where('employee_id',$emp_id)->first();

            $items = EmpPersonal::query()->where('company_id',$this->company_id)
                ->where('full_name', 'LIKE', '%'.$term.'%')
                ->with('professional')
                ->whereHas('professional', function($q) use($dept_id) {
                    $q->where('department_id', $dept_id->department_id);
                })
                ->orWhereHas('professional', function($q) use($term) {
                    $q->where('employee_id', 'LIKE',"%$term%");
                })
                ->get();
        }

        return response()->json($items);
    }

    public function employeeAttendance(Request $request, $date)
    {
        $term = $request['query'];

//        dd($term);

//            $emp_id = Auth::user()->emp_id;
//            $dept_id = EmpProfessional::query()->where('employee_id',$emp_id)->first();
//
//
//
//            $items = EmpPersonal::query()->where('company_id',$this->company_id)
//                ->where('full_name', 'LIKE', '%'.$term.'%')
//                ->with('professional')
//                ->orWhereHas('professional', function($q) use($term) {
//                    $q->where('employee_id', 'LIKE',"%$term%");
//                })
//                ->get();

        $att_date = Carbon::createFromFormat('d-m-Y',$date)->format('Y-m-d');


            $items = EmpProfessional::query()->where('company_id',$this->company_id)
                ->where('employee_id', 'LIKE',"%$term%")
                ->with('personal')
                ->orWhereHas('personal', function($q) use($term) {
                    $q->where('full_name', 'LIKE', '%'.$term.'%');
                })
//                ->with('attendance')
                ->with(['attendance' => function($q) use($att_date) {
                    $q->where('attend_date',  $att_date);
                }])
                ->get();

        return response()->json($items);
    }

    public function employeeDepartment(Request $request)
    {
        $term = $request['query'];
        $dept_id = Session::get('session_user_dept_id');

        $items = EmpPersonal::query()->where('company_id',$this->company_id)
            ->where('full_name', 'LIKE', '%'.$term.'%')
            ->with('professional')
            ->WhereHas('professional', function($q) use($term,$dept_id) {
                $q->where('department_id', $dept_id);
            })

            ->orWhereHas('professional', function($q) use($term,$dept_id) {
                $q->where('employee_id', 'LIKE',"%$term%")->where('department_id', $dept_id);
            })
            ->get();

        return response()->json($items);
    }

    public function employeeNameId(Request $request)
    {
        $term = $request['query'];

        $items = EmpPersonal::query()->where('company_id',$this->company_id)
            ->where('full_name', 'LIKE', '%'.$term.'%')
            ->with('professional')
            ->orWhereHas('professional', function($q) use($term) {
                $q->where('employee_id', 'LIKE',"%$term%");
            })
            ->get();

        return response()->json($items);
    }

    public function biodataSearch(Request $request)
    {
        $term = $request['query'];

        $items = BiodataCollection::query()->where('company_id',$this->company_id)
            ->where('name', 'LIKE', '%'.$term.'%')
            ->orWhere('mobile_no','LIKE', '%'.$term.'%')
            ->get();

        return response()->json($items);
    }

    public function doctors(Request $request)
    {
        $term = $request['query'];

        $db_ext = DB::connection('sqlsrv');
        $items =  $db_ext->table('doctor_main')->where('status','A')
            ->where('doctor_name', 'LIKE', '%'.$term.'%')
            ->get();

        return response()->json($items);
    }

    public function refDoctors(Request $request)
    {
        $term = $request['query'];

        $db_ext = DB::connection('sqlsrv');
        $items =  $db_ext->table('refer_doctor_master')->where('status','A')
            ->where('ref_doctor_name', 'LIKE', '%'.$term.'%')
            ->get();

        return response()->json($items);
    }
}
