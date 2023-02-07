<?php

namespace App\Http\Controllers\Roster;

use App\Models\Common\Department;
use App\Models\Common\Division;
use App\Models\Employee\EmpProfessional;
use App\Models\Roster\DutyLocation;
use App\Models\Roster\Roster;
use App\Models\Roster\RosterUpdateHistory;
use App\Models\Roster\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateRosterController extends Controller
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

        if(check_privilege(24,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        $emp_data = null;
        $monthId = intval(Carbon::now()->format('m'));
//        dd($monthId);

        if($request->filled('search_name'))
        {

            $emp_id = $request['search_id'];
            $year = $request['search_year'];
            $monthId = $request['search_month'];

//            dd($monthId);

            $emp_data = EmpProfessional::query()->where('company_id',$this->company_id)
                ->where('employee_id',$emp_id)
                ->with(['roster' => function ($query) use($year,$monthId) {
                $query->where('month_id',$monthId)->where('r_year',$year);
            }])
                ->with('personal')
                ->first();

            if(empty($emp_data->roster->month_id))
            {
//                dd($emp_data);
                $emp_data = null;
                return redirect()->back()->with('success', 'No Data found');
//                die();
//                return redirect()->back()->with('error','No Approved Roster Found For That Month');
            }
        }

        $shifts = Shift::query()->where('company_id',$this->company_id)
            ->select(DB::raw('CONCAT(short_name, " : ", from_time,"-",to_time) AS shift'), 'id')
            ->where('status',true)->pluck('shift','id');

//        dd($emp_data);

        $locations = DutyLocation::query()->where('company_id',$this->company_id)->where('status',true)->pluck('location','id');

        return view('roster.update-roster-index',compact('shifts','emp_data','locations','monthId'));
    }

    public function update(Request $request)
    {

        if(check_privilege(24,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        dd($request);

        DB::beginTransaction();

        try {

//            dd($request->all());
            $request['updated_by'] = $this->user_id;
            $request['updated_date'] = Carbon::now()->format('Y-m-d');

            Roster::query()->find($request->roster_id)->update($request->all());
            $roster= Roster::query()->find($request->roster_id);

//            dd($roster);

            $request['updated_by'] = $this->user_id;
            $request['updated_date'] = Carbon::now()->format('Y-m-d');
            $request['user_ip'] = $request->ip();
            $request['roster_id'] = $request->roster_id;
            $request['employee_id'] = $roster->employee_id;
            $request['r_year'] = $roster->r_year;
            $request['month_id'] = $roster->month_id;
            

//            $data = Roster:

            RosterUpdateHistory::query()->create($request->all());



        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Roster Data Updated'], 200);

    }

}
