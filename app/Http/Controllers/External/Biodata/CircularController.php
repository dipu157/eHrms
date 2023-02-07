<?php

namespace App\Http\Controllers\External\Biodata;

use App\Models\Common\Department;
use App\Models\Company\Bangladesh;
use App\Models\Company\Company;
use App\Models\Circular\Circular;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CircularController extends Controller
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
        $circular = Circular::query()->where('company_id',$this->company_id)->get();

       //dd($circular);

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');

        //dd($departments);

        return view('circular.circular-index',compact('departments','circular'));
    }

    public function circularData()
    {
        $circular = Circular::query()->where('company_id',1)->with('department')->get();

        $departments = Department::query()->where('company_id', $this->company_id)->where('status', true)->pluck('name', 'id');

        return DataTables::of($circular,$departments)

            ->addColumn('action', function ($circular) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$circular->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>

    <button data-remote="edit/' . $circular->id . '" data-rowid="'. $circular->id . '"data-circular_name="'. $circular->circular_name . '"data-department_id="'. $circular->department_id .'" data-expire_date = "'. $circular->expire_date . '" 
    type="button" href="#circular-update-modal" data-target="#circular-update-modal" data-toggle="modal" class="btn btn-sm btn-circular-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    ';
            })

            ->addColumn('status', function ($departments) {

                return $departments->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;

        DB::beginTransaction();

        try {

            $expire_date = Carbon::createFromFormat('d-m-Y',$request['expire_date'])->format('Y-m-d');

//            dd($started_from);

            $request['expire_date'] = $expire_date;

            Circular::create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('External\Biodata\CircularController@index');
    }

    public function update(Request $request)
    {
        // $departments = Department::query()->where('company_id', $this->company_id)->where('status', true)->pluck('name', 'id');

        DB::beginTransaction();

        try {

            $request['expire_date'] = Carbon::createFromFormat('d-m-Y',$request['expire_date']);
            Circular::find($request['id'])->update($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Circular\CircularController@index')->with('success',trans('message.success'));
    }

    public function applicantindex()
    {
        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');
        $districts = Bangladesh::query()->where('lang','en')->distinct()->orderBy('district')->pluck('district','district');
        $posts = Bangladesh::query()->where('lang','en')->orderBy('post_code')->pluck('post_code','post_code');

        $dhaka = Bangladesh::query()->where('id',49)->first();
        $company = Company::query()->where('id',1)->first();

        return view('circular.applicants-index',compact('departments','districts','posts','dhaka','company'));
    }

}
