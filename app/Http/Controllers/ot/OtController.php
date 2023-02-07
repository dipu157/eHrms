<?php

namespace App\Http\Controllers\OT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ot\OtModel;

class OtController extends Controller
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
        // if(check_privilege(720,1) == false) //2=show Division  1=view
        // {
        //     return redirect()->back()->with('error', trans('message.permission'));
        //     die();
        // }

        $data = OtModel::query()->where('company_id',$this->company_id)
        		->where('status',true)
                ->orderBy('id','desc')
                ->get();

        return view('ot.otIndex',compact('data'));
    }

    public function otDisplayIndex(Request $request)
    {
        // if(check_privilege(720,1) == false) //2=show Division  1=view
        // {
        //     return redirect()->back()->with('error', trans('message.permission'));
        //     die();
        // }

        $data = OtModel::query()->where('company_id',$this->company_id)
        		->where('status',true)
                ->orderBy('id','desc')
                ->get();

        return view('ot.otDisplay',compact('data'));
    }


    public function create(Request $request)
    {
        // if(check_privilege(720,2) == false) //2=show Division  1=view
        // {
        //     return redirect()->back()->with('error', trans('message.permission'));
        //     die();
        // }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;


        DB::beginTransaction();

        try {

            OtModel::query()->create($request->all());

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return redirect()->back()->with('error',$error)->withInput();
        }

        DB::commit();

        return redirect()->action('ot\OtController@index')->with('success','OT Data Added');


    }

    public function otStart(Request $request)
    {

        DB::beginTransaction();

        try {

            $data = OtModel::query()->where('id',$request['row_id'])->first();

            OtModel::query()->where('id',$request['row_id'])
            		->update(['ot_status' => $request->ot_status]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['success' => $error], 404);
        }

        DB::commit();

         return response()->json(['success' => 'OT Status Changed']);
    }

    public function otCallAttendent(Request $request)
    {

        DB::beginTransaction();

        try {

            $data = OtModel::query()->where('id',$request['row_id'])->first();

            OtModel::query()->where('id',$request['row_id'])
                    ->update(['ot_status' => $request->ot_status]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['success' => $error], 404);
        }

        DB::commit();

         return response()->json(['success' => 'OT Status Changed']);
    }

    public function otComplete(Request $request)
    {
        // if(check_privilege(720,4) == false) //2=show Division  1=view
        // {
        //     return redirect()->back()->with('error', trans('message.permission'));
        //     die();
        // }

        DB::beginTransaction();

        try {

            $data = OtModel::query()->where('id',$request['row_id'])->first();

            OtModel::query()->where('id',$request['row_id'])
            		->update(['status' => $request->status]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['success' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'OT Completed']);
    }
}
