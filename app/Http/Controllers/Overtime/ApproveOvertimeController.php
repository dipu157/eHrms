<?php

namespace App\Http\Controllers\Overtime;

use App\Models\Common\CommonLog;
use App\Models\Common\Department;
use App\Models\Overtime\OvertimeSetup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApproveOvertimeController extends Controller
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
        if(check_privilege(52,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $user_emp_id = Auth::user()->emp_id;
        $dept_id = $request->session()->get('session_user_dept_id');
        $ext_dept = Department::query()->where('report_to',$user_emp_id)->first();
        $ext_dept_id = is_null($ext_dept) ? null : $ext_dept->id;

//        dd($ext_dept_id);


        $data = OvertimeSetup::query()->where('company_id',$this->company_id)
            ->where('approval_status',false)
            ->with('professional')
            ->whereHas('professional', function($q) use($dept_id,$ext_dept_id) {
                $q->whereIn('department_id', [$dept_id,$ext_dept_id]);
            })
            ->orderBy('ot_date')
            ->get();


        return view('overtime.approve-overtime-index',compact('data'));
    }

    public function create(Request $request)
    {
        if(check_privilege(52,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = $request['check'];
        //$rec_date = date('Y-m-d H:i:s');



        DB::beginTransaction();

        try {

            switch($request['action'])
            {
                case 'approve' :

                //dd($rec_date);

                    foreach ($data as $row)
                    {
                        OvertimeSetup::query()->find($row)->update(['approval_status' => 1,'recommended_date'=>Carbon::now(), 'approver_id'=>$this->user_id]);
                    }

                    break;

                case 'reject':

                    $request['usecase_id'] = 35;
                    $request['entry_type'] = 'D';
                    $request['table_name'] = 'overtime_setups';
                    $request['new_data'] = 'Deleted';
                    $request['description'] = 'Rejected Overtime Setup Data';
                    $request['user_ip'] = $request->ip();
                    $request['user_id'] = $this->user_id;

                    foreach ($data as $row)
                    {

                        $deleted_data = OvertimeSetup::query()->where('id',$row)->first();
                        $request['old_data'] = implode($deleted_data->toArray(),' : ');

                        CommonLog::query()->create($request->all());

                        OvertimeSetup::query()->find($row)->delete();
                    }
                    break;
            }

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error',$error)->withInput();
        }

        DB::commit();

        return redirect()->action('Overtime\ApproveOvertimeController@index')->with('success','Overtime Data Approved/Rejected');
    }
}
