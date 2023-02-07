<?php

namespace App\Http\Controllers\Admin;

use App\Models\Common\Department;
use App\Models\Common\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SectionController extends Controller
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
        if(check_privilege(13,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',1)->pluck('name','id');
        return view('admin.section-index',compact('departments'));
    }

    public function sectionData()
    {
        $sections = Section::query()->where('company_id',1)->with('department')->get();


        return DataTables::of($sections)

            ->addColumn('action', function ($sections) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$sections->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>
                    <button data-remote="edit/' . $sections->id . '" data-rowid="'. $sections->id . '" 
                        data-name="'. $sections->name . '" 
                        data-shortname="'. $sections->short_name . '" 
                        data-email="'. $sections->email . '"
                        data-description="'. $sections->description . '"
                        type="button" href="#section-update-modal" data-target="#section-update-modal" data-toggle="modal" class="btn btn-sm btn-section-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    ';
            })

            ->addColumn('status', function ($sections) {

                return $sections->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {
//        dd($request);

        if(check_privilege(13,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;

        DB::beginTransaction();

        try {


            $started_from = Carbon::createFromFormat('d-m-Y',$request['started_from'])->format('Y-m-d');

            $request['email'] = $request->filled('email') ? $request['email'] : int_random(11111,99999).'@brbhospital.com';
            $request['started_from'] = $started_from;

            Section::create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Admin\SectionController@index');
    }

    public function update()
    {
        if(check_privilege(13,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
    }


}
