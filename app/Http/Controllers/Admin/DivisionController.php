<?php

namespace App\Http\Controllers\Admin;

use App\Models\Common\Division;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DivisionController extends Controller
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
        if(check_privilege(11,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('admin.division-index');
    }

    public function divisionData()
    {
        $divisions = Division::query()->where('company_id',1)->get();


        return DataTables::of($divisions)

            ->addColumn('action', function ($divisions) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$divisions->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>
                    <button data-remote="edit/' . $divisions->id . '" data-rowid="'. $divisions->id . '" 
                        data-name="'. $divisions->name . '" 
                        data-shortname="'. $divisions->short_name . '" 
                        data-email="'. $divisions->email . '"
                        data-description="'. $divisions->description . '"
                        type="button" href="#division-update-modal" data-target="#division-update-modal" data-toggle="modal" class="btn btn-sm btn-division-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    ';
            })

            ->addColumn('status', function ($divisions) {

                return $divisions->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {
//        dd($request);

        if(check_privilege(11,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;

        DB::beginTransaction();

        try {

            $request['email'] = $request->filled('email') ? $request['email'] : int_random(11111,99999).'@brbhospital.com';
            $started_from = Carbon::createFromFormat('d-m-Y',$request['started_from'])->format('Y-m-d');

//            dd($started_from);

            $request['started_from'] = $started_from;

            Division::create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Admin\DivisionController@index');
    }

    public function update(Request $request)
    {
//        dd($request);

        if(check_privilege(11,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            $request['started_from'] = Carbon::createFromFormat('d-m-Y',$request['started_from']);
            Division::find($request['id'])->update($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Admin\DivisionController@index')->with('success',trans('message.success'));
    }
}
