<?php

namespace App\Http\Controllers\Attendance;

use App\Models\Attendance\PublicHoliday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class HolidaySetupController extends Controller
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
        if(check_privilege(34,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('attendance.holiday-setup-index');
    }

    public function holidaysData()
    {
        $holidays = PublicHoliday::query()->where('company_id',1)->get();


        return DataTables::of($holidays)

            ->addColumn('action', function ($holidays) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$holidays->id.'"  type="button" class="btn btn-info btn-sm"><i class="fa fa-folder-open">View</i></button>
                    
                    <button data-remote="edit/' . $holidays->id . '" data-rowid="'. $holidays->id . '" 
                        data-name="'. $holidays->name . '" 
                        data-shortname="'. $holidays->short_name . '" 
                        data-fromtime="'. $holidays->from_time . '" 
                        data-totime="'. $holidays->to_time . '" 
                        data-hour="'. $holidays->duty_hour . '"
                        data-status="'. $holidays->status . '"
                        data-nextdate="'. $holidays->end_next_day . '"
                        type="button" href="#modal-edit-shift" data-target="#modal-edit-shift" data-toggle="modal" class="btn btn-sm btn-shift-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    
                    <button data-remote="delete/'.$holidays->id.'"  type="button" class="btn btn-danger btn-sm btn-secondary"><i class="fa fa-trash">Delete</i></button>
                    
                    ';
            })

            ->addColumn('status', function ($shifts) {

                return $shifts->status == true ? 'Active' : 'Disabled';
            })



            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {

        if(check_privilege(34,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['hYear'] = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y');
        $request['from_date'] = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
        $request['to_date'] = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
        $request['count'] = dateDifference($request['from_date'],$request['to_date']) + 1;


        DB::beginTransaction();

        try {

            PublicHoliday::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'New Holiday Data Added'], 200);
    }


    public function update(Request $request)
    {

        if(check_privilege(34,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            PublicHoliday::query()->where('id',$request['id-for-update'])->update($request->except('_token','id-for-update'));


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return response()->json(['success' => 'Holiday Data Updated'], 200);
    }
}
