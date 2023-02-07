<?php

namespace App\Http\Controllers\Leave;

use App\Models\Leaves\LeaveMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LeaveMasterController extends Controller
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
        if(check_privilege(28,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('leave.index.master-leave-index');
    }


    public function trainingData()
    {
        $leaves = LeaveMaster::query()->where('company_id',1)->get();


        return DataTables::of($leaves)

            ->addColumn('action', function ($leaves) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$leaves->id.'"  type="button" class="btn btn-info btn-view btn-sm"><i class="fa fa-folder-open">View</i></button>
                    
                    <button data-remote="edit/' . $leaves->id . '" data-rowid="'. $leaves->id . '" 
                        data-title="'. $leaves->title . '" 
                        data-description="'. $leaves->description . '" 
                        data-trainer="'. $leaves->trainer . '" 
                        data-start="'. $leaves->start_from . '" 
                        data-end="'. $leaves->end_on . '" 
                        data-participants="'. $leaves->participants . '"
                        data-status="'. $leaves->status . '"
                        type="button" href="#modal-edit-leaves" data-target="#modal-edit-leaves" data-toggle="modal" class="btn btn-sm btn-leave-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    
                    ';
            })

            ->addColumn('status', function ($trainings) {

                return $trainings->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {
        if(check_privilege(28,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        dd($request)

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;

        DB::beginTransaction();

        try {

            LeaveMaster::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'New Leave Data Added'], 200);
    }

    public function update(Request $request)
    {
        if(check_privilege(28,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            LeaveMaster::query()->where('id',$request['id-for-update'])->update($request->except('_token','id-for-update'));


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Training Data Updated'], 200);
    }

    public function view($id)
    {
        $leaves = LeaveMaster::query()->where('company_id',1)->where('id',$id)->first();

        return view('training.view-training',compact('leaves'));
    }
}
