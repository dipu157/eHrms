<?php

namespace App\Http\Controllers\Roster;

use App\Models\Common\Department;
use App\Models\Common\Division;
use App\Models\Common\Section;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Models\Roster\DutyLocation;
use App\Models\Roster\Roster;
use App\Models\Roster\Shift;
use Carbon\Carbon;
use Validator;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


class EmployeeRosterController1 extends Controller
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

        if(check_privilege(23,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        $divisions = Division::query()->where('company_id',$this->company_id)->pluck('name','id');
        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');

        $sections = Section::query()->where('company_id',$this->company_id)
            ->where('department_id',$request->session()->get('session_user_dept_id'))->pluck('name','id');

        $user_dept = Department::query()->where('id',$request->session()->get('session_user_dept_id'))->first();

        $month_days = cal_days_in_month(CAL_GREGORIAN,$user_dept->roster_month_id,$user_dept->roster_year);

        $r_year = $user_dept->roster_year;
        $r_month = $user_dept->roster_month_id;

        $data_list = EmpProfessional::query()
            ->with(['roster'=>function ($query) use($r_month,$r_year){
                $query->where('r_year',$r_year)->where('month_id',$r_month)
                    ->orderBy('employee_id','desc');
            }])
            ->with('personal')->with('department')
            ->where('company_id',$this->company_id)
            ->where('department_id',$request->session()->get('session_user_dept_id'))
            ->whereIn('working_status_id',[1,2,8])
            ->take(60)
            ->get();

            $emp_list = $data_list->where('roster.status',false);

//            Get Single Single Employee Roster

            if($request->filled('search_name'))
            {

                $r_year = $request['r_year'];
                $r_month = $request['r_month'];

                $emp_id = $request['search_id'];

                $emp_list = EmpProfessional::query()->where('company_id',$this->company_id)
                    ->where('employee_id',$emp_id)
                    ->with(['roster'=>function ($query) use($r_month,$r_year){
                        $query->where('r_year',$r_year)->where('month_id',$r_month)
                            ->orderBy('employee_id','desc');
                    }])
                    ->with('personal')
                    ->get();

            }

            //Employee By Section

            if($request->filled('section_id'))
            {

                $r_year = $request['r_year'];
                $r_month = $request['r_month'];

                $section_id = $request['section_id'];

                $emp_list = EmpProfessional::query()->where('company_id',$this->company_id)
                    ->where('section_id',$section_id)
                    ->with(['roster'=>function ($query) use($r_month,$r_year){
                        $query->where('r_year',$r_year)->where('month_id',$r_month)
                            ->orderBy('employee_id','desc');
                    }])
                    ->with('personal')
                    ->get();

            }

        // For Employee Joined After Approved

            if($request->filled('search_new'))
            {

                $r_year = $request['search_year'];
                $r_month = $request['search_month'];

                $month_days=cal_days_in_month(CAL_GREGORIAN,$user_dept->roster_month_id,$user_dept->roster_year);

                $emp_list  = EmpProfessional::query()->where('company_id',$this->company_id)
                    ->where('department_id',$request->session()->get('session_user_dept_id'))
                    ->whereIn('working_status_id',[1,2,8])
                    ->with('roster')
                    ->whereDoesntHave('roster',function (Builder $query) use($r_year,$r_month){
                        $query->where('r_year',$r_year)->where('month_id',$r_month);
                    } )
                    ->get();
            }

        $shifts = Shift::query()->where('company_id',$this->company_id)
            ->select(DB::raw('CONCAT(short_name, " : ", from_time,"-",to_time) AS shift'), 'id')
            ->where('status',true)->pluck('shift','id');

        $locations = DutyLocation::query()->where('company_id',$this->company_id)->where('status',true)->pluck('location','id');

        return view('roster.employee-roster-index',compact('divisions','shifts','emp_list','locations','departments','sections','month_days','r_year','r_month'));
    }

    public function create(Request $request)
    {

        if(check_privilege(23,2) == false) //2=show Division  1=view
        {
//            return response()->json('error', trans('message.permission'),404);
            return response()->json(['error' => trans('message.permission')], 404);
            die();
        }


        $emp_id = Auth::user()->emp_id;
        $emp_dept = EmpProfessional::query()->where('employee_id',$emp_id)->first();
        $dept_data = Department::query()->where('company_id',$this->company_id)->where('id',$emp_dept->department_id)->first();

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = false;
//        $request['r_year'] = $request['r_year'];
        $request['month_id'] = $request['r_month'];
        $request['inserted_by'] = $this->user_id;
        $request['department_id'] = $emp_dept->department_id;


        DB::beginTransaction();

        try {

            switch ($request['week_id'])
            {
                case    'first':

                    $data = Roster::query()->where('company_id', $this->company_id)
                            ->where('employee_id',$request['employee_id'])
                            ->where('r_year',$request['r_year'])
                            ->where('month_id',$request['month_id']);

                    if (Roster::query()->where('company_id', $this->company_id)
                        ->where('employee_id',$request['employee_id'])->where('r_year',$request['r_year'])->where('month_id',$request['month_id'])
                        ->exists())
                    {
                        return response()->json(['error' => 'Roster Already Inserted. For update the roster contact with your Department Head!'], 404);

                        
                    }

                     $validator = Validator::make($request->all(), [
                        'day_01' => 'required',
                        'day_02' => 'required',
                        'day_03' => 'required',
                        'day_04' => 'required',
                        'day_05' => 'required',
                        'day_06' => 'required',
                        'day_07' => 'required',
                        'day_08' => 'required',
                        'day_09' => 'required',
                        'day_10' => 'required',
                        'day_11' => 'required',
                        'day_12' => 'required',
                        'day_13' => 'required',
                        'day_14' => 'required',
                        'day_15' => 'required',
                        'day_16' => 'required',
                        'day_17' => 'required',
                        'day_18' => 'required',
                        'day_19' => 'required',
                        'day_20' => 'required',
                        'day_21' => 'required',
                        'day_22' => 'required',
                        'day_23' => 'required',
                        'day_24' => 'required',
                        'day_25' => 'required',
                        'day_26' => 'required',
                        'day_27' => 'required',
                        'day_28' => 'required',
                        'day_29' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['error' => 'Please Select All Days Roaster'], 404);
                    }else{

                        $request['loc_02'] = $request['loc_01'];
                        $request['loc_03'] = $request['loc_01'];
                        $request['loc_04'] = $request['loc_01'];
                        $request['loc_05'] = $request['loc_01'];
                        $data = Roster::query()->create($request->all());
                    }

                    break;

            }


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
//            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();


        return json_encode($data);
    }
}
