<?php

namespace App\Http\Controllers\Roster;

use App\Models\Common\Department;
use App\Models\Common\Section;
use App\Models\Roster\Roster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Config;

class ApproveRosterController extends Controller
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

        if(check_privilege(25,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $dept_id = null;
        $msg = null;
        $previous = 0;


        if ($request->session()->has('session_user_dept_id')) {
            $dept_id = $request->session()->get('session_user_dept_id');//
            $dept_data = Department::query()->where('id',$dept_id)->first();
            $month = get_month_from_number($dept_data->roster_month_id);
            $year = $dept_data->roster_year;
        }

        $pre_month = $dept_data->roster_month_id == 1 ? 12 : $dept_data->roster_month_id - 1;
        $pre_year = $dept_data->roster_month_id == 1 ? $dept_data->roster_year - 1 : $dept_data->roster_year;

        $sections = Section::query()->where('company_id',$this->company_id)
            ->where('department_id',$request->session()->get('session_user_dept_id'))->pluck('name','id');


        $pre_data = $data = Roster::query()->where('company_id',$this->company_id)
            ->where('department_id',$dept_id)
            ->where('r_year',$pre_year)
            ->where('month_id',$pre_month)
            ->where('status',false)
            ->with('professional')->get();

        if(count($pre_data) > 0)
        {
            $data = $pre_data;
            $month = $pre_month;
            $year= $pre_year;
            $previous = 1;

        }else{

            $data = Roster::query()->where('company_id',$this->company_id)
                ->where('department_id',$dept_id)
                ->where('r_year',$dept_data->roster_year)
                ->where('month_id',$dept_data->roster_month_id)
                ->where('status',false)
                ->with('professional')->get();
        }


        if($request->filled('search_id'))
        {
            $data = Roster::query()->where('company_id',$this->company_id)
                ->where('department_id',$dept_id)
                ->where('r_year',$dept_data->roster_year)
                ->where('month_id',$dept_data->roster_month_id)
                ->where('status',false)->where('employee_id',$request['search_id'])
                ->with('professional')->get();
        }


        if($request->filled('section_id'))
        {

            $section = $request['section_id'];

//            dd($section);

            $data = Roster::query()->where('company_id',$this->company_id)
                ->where('department_id',$dept_id)
                ->where('r_year',$dept_data->roster_year)
                ->where('month_id',$dept_data->roster_month_id)
                ->where('status',false)
                ->with('professional')
                ->whereHas('professional',function ($query) use($section){
                    $query->where('section_id',$section);
                })
                ->get();

//            dd($data);
        }



//            ->paginate(5);


        return view('roster.approve-roster-index',compact('data','month','year','previous','sections'));
    }

    public function approve(Request $request)
    {

        $data = $request['check'];
        $dept_id = $request->session()->get('session_user_dept_id');
        $dept_data = Department::query()->where('id',$dept_id)->first();


        $dt = $dept_data->roster_year.'-'.$dept_data->roster_month_id.'-'.'01';
        $next_month = intval(date('m', strtotime('+1 month', strtotime($dt))));
        $next_year = $dept_data->roster_month_id == 12 ?  $dept_data->roster_year + 1 : $dept_data->roster_year;

        $no_of_days= cal_days_in_month(CAL_GREGORIAN,$dept_data->roster_month_id,$dept_data->roster_year);

        DB::beginTransaction();

        try {

            if(!empty($data))
            {
                foreach ($data as $count=>$r_id)
                {
                    $roster = Roster::query()->where('id',$r_id)->first();

                    // Make Roster as general if any roster data is null for the employee

                    if($request['is_previous'] == 0)
                    {
                        for($i=1; $i <= $no_of_days; $i++)
                        {
                            $field = 'day_'.sprintf("%02d", $i);

                            $roster_id = date('D', strtotime($dept_data->roster_year.'-'.$dept_data->roster_month_id.'-'.$i)) == 'Fri' ? 1 : 2;
                            $roster->{$field} == null ? Roster::query()->find($r_id)->update([$field=>$roster_id]) : null;

                        }

                    }

                    Roster::query()->find($r_id)->update(['approved_by'=>$this->user_id, 'approved_date'=>Carbon::now(),'status'=>true]);

                }

                if($request['is_previous'] == 0)
                {
                    $oppen = Roster::query()->where('r_year',$dept_data->roster_year)
                        ->where('month_id',$dept_data->roster_month_id)
                        ->where('department_id',$dept_id)
                        ->where('status',false)
                        ->count();

                    if($oppen==0)
                    {
                        Department::query()->where('id',$dept_id)->update(['roster_month_id'=>$next_month,'roster_year'=>$next_year]);
                    }
                }

            }else
            {
                return redirect()->back()->with('error','Please Check The Checkbox');
            }

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

//        dd('here');

        DB::commit();

        return redirect()->action('Roster\ApproveRosterController@index')->with('success','Roster Data Approved/Rejected');
    }
}
