<?php

namespace App\Http\Controllers\Attendance;

use App\Models\Attendance\OnDuty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OnDutyEmployeeController extends Controller
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
        if(check_privilege(42,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = OnDuty::query()->where('company_id',$this->company_id)
            ->orderBy('id','DESC')
            ->take(5)
            ->get();

        if($request->filled('search_id'))
        {

            $data = OnDuty::query()->where('company_id',$this->company_id)
                ->where('employee_id',$request['search_id'])
                ->with('professional')
                ->orderBy('id','desc')
                ->get();

        }


        return view('attendance.on-duty-setup-index',compact('data'));
    }

    public function create(Request $request)
    {

        if(check_privilege(42,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['employee_id'] = $request['to_emp_id'];
        $request['from_date'] = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
        $request['to_date'] = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
        $request['nods'] = dateDifference($request['from_date'],$request['to_date']) + 1;
        $today = Carbon::now()->format('Y-m-d');
        $request['application_time'] = $request['to_date'] < $today ? 'A' : 'B';
        $request['duty_year'] = Carbon::createFromFormat('Y-m-d',$request['from_date'])->format('Y');


        DB::beginTransaction();

        try {

            OnDuty::query()->create($request->all());

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error',$error)->withInput();
        }

        DB::commit();

        return redirect()->action('Attendance\OnDutyEmployeeController@index')->with('success','Data Added Successfully');

    }

    public function destroy(Request $request)
    {

        if(check_privilege(42,4) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            $data = OnDuty::query()->where('id',$request['row_id'])->first();

//            dd($data);

            if($data->posted == true)
            {
                return response()->json(['error' => 'Data Already Posted To Salary. Not possible to delete'], 404);
                die();
            }

//            $data = OnDuty::query()->where('id',$request['row_id'])->first();

            OnDuty::query()->where('id',$request['row_id'])->delete();


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['success' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'On Duty Data Deleted','row-id' => $request['row_id']], 200);
    }
}
