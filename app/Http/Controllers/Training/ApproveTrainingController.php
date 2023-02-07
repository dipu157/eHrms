<?php

namespace App\Http\Controllers\Training;


use App\Models\Common\Department;
use App\Models\Employee\EmpProfessional;
use App\Models\Training\Trainee;
use App\Models\Training\Training;
use App\Models\Training\TrainingSchedule;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class ApproveTrainingController extends Controller
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
        if(check_privilege(747,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $user_emp_id = Auth::user()->emp_id;
        $dept_id = $request->session()->get('session_user_dept_id');
        $ext_dept = Department::query()->where('report_to',$user_emp_id)->first();
        $ext_dept_id = is_null($ext_dept) ? null : $ext_dept->id;

//        dd($ext_dept_id);


       


            
            $data = Trainee::query()->select('trainees.id', 'trainees.employee_id', 'trainees.training_date', 'training_schedules.start_from', 'training_schedules.end_on', 'trainings.title', 'trainees.approver_id', 'trainees.reason', 'trainees.recommended_date')
            ->where('trainees.attended','=',0)
     
            ->with('approver')
            ->with('employee')
            ->whereHas('employee', function($q) use($dept_id,$ext_dept_id) {
                $q->whereIn('department_id', [$dept_id,$ext_dept_id]);
            })
            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'trainees.employee_id')
            ->join('training_schedules', 'trainees.training_schedule_id', '=', 'training_schedules.id')
            ->join('trainings', 'training_schedules.training_id', '=', 'trainings.id')
    
                ->where('trainees.approval_status','=',0)->where('trainees.status','=',1)
            
                ->orderBy('trainees.training_date','trainees.employee_id','ASC')
                
            ->get();


        return view('training.approve_training_setup_index',compact('data'));
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

//dd($data);

        DB::beginTransaction();

        try {

            switch($request['action'])
            {
                case 'approve' :

                //dd($rec_date);

                    foreach ($data as $row)
                    {
                        Trainee::query()->find($row)->update(['approval_status'=>true,'recommended_date'=>Carbon::now(), 'approver_id'=>$this->user_id]);
                    }

                    break;

                case 'reject':

              

                    foreach ($data as $row)
                    {

                        Trainee::query()->find($row)->update(['status'=>0,'recommended_date'=>Carbon::now(), 'approver_id'=>$this->user_id]);
                   
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

        return redirect()->action('Training\ApproveTrainingController@index')->with('success','Training Data Approved/Rejected');
    }
}
