<?php

namespace App\Http\Controllers\Roster;

use App\Models\Common\Location;
use App\Models\Roster\DutyLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DutyLocationController extends Controller
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
        if(check_privilege(21,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('roster.location-index');
    }

    public function locationData()
    {
        $locations = DutyLocation::query()->where('company_id',1)->get();


        return DataTables::of($locations)

            ->addColumn('action', function ($locations) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$locations->id.'"  type="button" class="btn btn-info btn-sm"><i class="fa fa-folder-open">View</i></button>
                    
                    <button data-remote="edit/' . $locations->id . '" data-rowid="'. $locations->id . '" 
                        data-location="'. $locations->location . '" 
                        data-status="'. $locations->status . '"
                        data-description="'. $locations->description . '"
                        type="button" href="#modal-edit-location" data-target="#modal-edit-location" data-toggle="modal" class="btn btn-sm btn-location-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    
                    <button data-remote="delete/'.$locations->id.'"  type="button" class="btn btn-danger btn-sm btn-secondary"><i class="fa fa-trash">Delete</i></button>
                    
                    ';
            })

            ->addColumn('status', function ($locations) {

                return $locations->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {
        if(check_privilege(21,2) == false) //2=show Division  1=view
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

            DutyLocation::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'New Location Data Added'], 200);
    }
}
