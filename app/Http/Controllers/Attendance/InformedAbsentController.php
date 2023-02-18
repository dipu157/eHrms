<?php

namespace App\Http\Controllers\Attendance;

use App\Models\Attendance\InformedAbsent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InformedAbsentController extends Controller
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

        $data = InformedAbsent::query()->where('company_id',$this->company_id)
            ->orderBy('id','DESC')
            ->take(5)
            ->get();

        if($request->filled('search_id'))
        {

            $data = InformedAbsent::query()->where('company_id',$this->company_id)
                ->where('employee_id',$request['search_id'])
                ->with('professional')
                ->orderBy('id','desc')
                ->get();

        }


        return view('attendance.informedAbsent-setup-index',compact('data'));
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
        $request['status_id'] = $request['status_id'];
        $request['from_date'] = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
        $request['to_date'] = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');
        $request['nods'] = dateDifference($request['from_date'],$request['to_date']) + 1;
        $today = Carbon::now()->format('Y-m-d');
        $request['absent_year'] = Carbon::createFromFormat('Y-m-d',$request['from_date'])->format('Y');

        //dd($request['status_id']);


        DB::beginTransaction();

        try {

            InformedAbsent::query()->create($request->all());

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error',$error)->withInput();
        }

        DB::commit();

        return redirect()->action('Attendance\InformedAbsentController@index')->with('success','Data Added Successfully');

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

            $data = InformedAbsent::query()->where('id',$request['row_id'])->first();

//            $data = OnDuty::query()->where('id',$request['row_id'])->first();

            InformedAbsent::query()->where('id',$request['row_id'])->delete();


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['success' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Absent Data Deleted','row-id' => $request['row_id']], 200);
    }
}
