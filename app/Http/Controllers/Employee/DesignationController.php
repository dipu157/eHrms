<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee\Designation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DesignationController extends Controller
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
        if(check_privilege(16,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        return view('employee.designation-index');
    }

    public function designationData()
    {
        $designations = Designation::query()->where('company_id',1)->get();


        return DataTables::of($designations)

            ->addColumn('action', function ($designations) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$designations->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>
                    <button data-remote="edit/' . $designations->id . '" data-rowid="'. $designations->id . '" 
                        data-name="'. $designations->name . '" 
                        data-shortname="'. $designations->short_name . '" 
                        data-precedence="'. $designations->precedence . '" 
                        type="button" href="#designation-update-modal" data-target="#designation-update-modal" data-toggle="modal" class="btn btn-sm btn-designation-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    ';
            })

            ->addColumn('status', function ($designations) {

                return $designations->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {
//        dd($request);

        if(check_privilege(16,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;

        DB::beginTransaction();

        try {

            Designation::create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Employee\DesignationController@index');
    }

    public function update(Request $request)
    {
        if(check_privilege(16,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            Designation::query()->where('id',$request['id'])->update(['name'=>$request['name'],'short_name'=>$request['short_name'],'precedence'=>$request['precedence']]);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Updated '.$error);
        }

        DB::commit();

        return redirect()->action('Employee\DesignationController@index')->with('success','Successfully Updated');
    }
}
