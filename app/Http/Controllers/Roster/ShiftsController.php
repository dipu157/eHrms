<?php

namespace App\Http\Controllers\Roster;

use App\Models\Roster\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ShiftsController extends Controller
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
        if(check_privilege(22,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('roster.shift-settings-index');
    }

    public function shiftData()
    {
        $shifts = Shift::query()->where('company_id',1)->get();


        return DataTables::of($shifts)

            ->addColumn('action', function ($shifts) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$shifts->id.'"  type="button" class="btn btn-info btn-sm"><i class="fa fa-folder-open">View</i></button>
                    
                    <button data-remote="edit/' . $shifts->id . '" data-rowid="'. $shifts->id . '" 
                        data-name="'. $shifts->name . '" 
                        data-shortname="'. $shifts->short_name . '" 
                        data-session_id="'. $shifts->session_id . '" 
                        data-fromtime="'. $shifts->from_time . '" 
                        data-totime="'. $shifts->to_time . '" 
                        data-hour="'. $shifts->duty_hour . '"
                        data-status="'. $shifts->status . '"
                        data-nextdate="'. $shifts->end_next_day . '"
                        type="button" href="#modal-edit-shift" data-target="#modal-edit-shift" data-toggle="modal" class="btn btn-sm btn-shift-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    
                    <button data-remote="delete/'.$shifts->id.'"  type="button" class="btn btn-danger btn-sm btn-secondary"><i class="fa fa-trash">Delete</i></button>
                    
                    ';
            })

            ->addColumn('status', function ($shifts) {

                return $shifts->status == true ? 'Active' : 'Disabled';
            })

            ->addColumn('shifttime', function ($shifts) {

                return $shifts->from_time. ' To '.$shifts->to_time ;
            })

            ->addColumn('nextday', function ($shifts) {

                return $shifts->end_next_day == true ? 'Yes' : 'No';
            })


            ->rawColumns(['action','status','nextday','shifttime'])
            ->make(true);
    }

    public function create(Request $request)
    {
//        dd($request);

        if(check_privilege(22,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['terminal'] = $request->ip();
        $request['effective_date'] = Carbon::createFromFormat('d-m-Y',$request['effective_from']);

        $max_code = Shift::query()->where('company_id',1)->max('shift_code');
        $request['shift_code'] = $max_code + 1;

        DB::beginTransaction();

        try {

            Shift::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'New Shift Data Added'], 200);
    }


    public function update(Request $request)
    {
        if(check_privilege(22,3) == false) //2=show Division  1=view
        {
//            return redirect()->back()->with('error', trans('message.permission'));
            return response()->json(['error' => trans('message.permission')], 404);
            die();
        }

//        $request['effective_date'] = Carbon::createFromFormat('d-m-Y',$request['effective_from']);

        DB::beginTransaction();

        try {

//            dd($request['id-for-update']);

            Shift::query()->where('id',$request['id-for-update'])->update($request->except('_token','id-for-update'));


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'New Shift Data Added'], 200);
    }
}
