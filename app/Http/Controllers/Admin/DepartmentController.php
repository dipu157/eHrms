<?php

namespace App\Http\Controllers\Admin;

use App\Models\Common\Department;
use App\Models\Common\Division;
use App\Models\Common\Privilege;
use App\Models\Common\UseCase;
use App\Models\Employee\EmpProfessional;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller
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
        if(check_privilege(12,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        $emps = EmpProfessional::query()->whereIn('department_id',[13])
//            ->where('status',true)->where('working_status_id',1)
//            ->with('personal')
//            ->get();
//
//
//        foreach ($emps as $row)
//        {
//            User::query()->firstOrCreate (['emp_id' =>$row->employee_id],
//                ['company_id' => 1,
//                'role_id' => 3,
//                'name' => $row->personal->full_name,
//                'email' => $row->employee_id.'@brbhospital.com',
//                'password' => Hash::make('power123'),
//            ]);
//
//        }
////
//        dd('here');


//        $users = User::query()->where('role_id',3)->get();
//
//        $new = Collect();
//
//        foreach ($users as $i=>$user)
//        {
//
//                $id= Privilege::query()->firstOrCreate(['user_id'=>$user->id,'menu_id'=>'29'],
//                    ['group_id'=>'F','company_id'=>1,'approver_id'=>1,
//                    'view'=>true,'add'=>true,'edit'=>false,'delete'=>false]);
//
//                Privilege::query()->firstOrCreate(['user_id'=>$user->id,'menu_id'=>'32'],
//                    ['group_id'=>'F','company_id'=>1,'approver_id'=>1,
//                        'view'=>true,'add'=>true,'edit'=>false,'delete'=>false]);
//
//                $new->push($id);
//
//        }
//
//        dd($new);



        $divisions = Division::query()->where('company_id',1)->pluck('name','id');
        return view('admin.department-index',compact('divisions'));
    }

    public function departmentData()
    {
        $departments = Department::query()->where('company_id',1)->with('division')->get();


        return DataTables::of($departments)

            ->addColumn('action', function ($departments) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$departments->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>
                    <button data-remote="edit/' . $departments->id . '" data-rowid="'. $departments->id . '" 
                        data-name="'. $departments->name . '" 
                        data-shortname="'. $departments->short_name . '" 
                        data-code="'. $departments->department_code . '"
                        data-top="'. $departments->top_rank . '"
                        data-email="'. $departments->email . '"
                        data-description="'. $departments->description . '"
                        data-leave = "'. $departments->leave_steps . '"
                        type="button" href="#department-update-modal" data-target="#department-update-modal" data-toggle="modal" class="btn btn-sm btn-department-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
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

        if(check_privilege(12,2) == false) //2=show Division  1=view
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

            Department::create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Admin\DepartmentController@index');
    }

    public function update(Request $request)
    {
        if(check_privilege(12,3) == false) //2=show Division  1=view
        {
            return response()->json(['error' => trans('message.permission')], 404);
//                redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $a = $request->has('apply') ? '1' : 0;
        $b = $request->has('acknowledge') ? '1' : 0;
        $c = $request->has('recommend') ? '1' : 0;
        $d = $request->has('approve') ? '1' : 0;

        $request['leave_steps'] = $a.$b.$c.$d;

        DB::beginTransaction();

        try {

            $request['started_from'] = Carbon::createFromFormat('d-m-Y',$request['started_from']);

            Department::query()->where('id',$request['id'])->update($request->except('_token','id','apply','acknowledge','recommend','approve'));


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => 'Not Updated '.$error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Data successfully updated'], 200);
    }
}
