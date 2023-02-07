<?php

namespace App\Http\Controllers\Employee;

use App\Models\Company\Bangladesh;
use App\Models\Employee\Title;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TitleController extends Controller
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

//        $jsonString = file_get_contents(base_path('resources/lang/en/postcode1.json'));
//
//        $data = json_decode($jsonString, true);

//dd($data);

//        foreach ($data as $row)
//        {
//            dd($row);

//            Bangladesh::insert([
//                'lang'=>'en',
//                'division'=>$row['en']['division'],
//                'district'=>$row['en']['district'],
//                'thana'=>$row['en']['thana'],
//                'post_office'=>$row['en']['suboffice'],
//                'post_code'=>$row['en']['postcode'],
//
//
//            ]);


//            Bangladesh::insert([
//                'lang'=>'bn',
//                'division'=>$row['bn']['division'],
//                'district'=>$row['bn']['district'],
//                'thana'=>$row['bn']['thana'],
//                'post_office'=>$row['bn']['suboffice'],
//                'post_code'=>$row['bn']['postcode'],
//
//
//            ]);

//            dd($row['en']['division']);

//        }



//        dd($data);

        if(check_privilege(17,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        return view('employee.title-index');
    }

    public function titleData()
    {
        $titles = Title::query()->where('company_id',1)->get();


        return DataTables::of($titles)

            ->addColumn('action', function ($titles) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$titles->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>
                    <button data-remote="edit/' . $titles->id . '" data-rowid="'. $titles->id . '" 
                        data-name="'. $titles->name . '" 
                        data-description="'. $titles->description . '" 
                        type="button" href="#title-update-modal" data-target="#title-update-modal" data-toggle="modal" class="btn btn-sm btn-title-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    ';
            })

            ->addColumn('status', function ($titles) {

                return $titles->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function create(Request $request)
    {
//        dd($request);

        if(check_privilege(17,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;

        DB::beginTransaction();

        try {

            Title::create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Employee\TitleController@index');
    }

    public function update(Request $request)
    {

        if(check_privilege(17,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            Title::query()->where('id',$request['id'])->update(['name'=>$request['name'],'description'=>$request['description']]);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Employee\TitleController@index');
    }
}
