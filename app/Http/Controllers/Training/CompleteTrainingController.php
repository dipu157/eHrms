<?php

namespace App\Http\Controllers\Training;

use App\Models\Employee\EmpProfessional;
use App\Models\Training\Trainee;
use App\Models\Training\Training;
use App\Models\Training\TrainingSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompleteTrainingController extends Controller
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

    public function index($schID)
    {
//        if(check_privilege(61,1) == false) //2=show Division  1=view
//        {
//            return redirect()->back()->with('error', trans('message.permission'));
//            die();
//        }


        $training = TrainingSchedule::query()->where('company_id',$this->company_id)
            ->where('id',$schID)
            ->with('training')
            ->first();

        $emp_count = EmpProfessional::query()
            ->select('emp_professionals.department_id', DB::Raw('count(emp_professionals.employee_id) as total'),
                DB::Raw('count(trainees.employee_id) as participant'),
                DB::Raw('sum(case when(trainees.attended = 1) then 1 else 0 end) as attended'),
                DB::Raw('sum(case when(trainees.attended = 1) then 0 else 1 end) as absent')
            )
            ->join('trainees', function ($join) use($schID) {
                $join->on('emp_professionals.employee_id', '=', 'trainees.employee_id')
                    ->where('trainees.training_schedule_id',$schID);
            })
            ->groupBy('emp_professionals.department_id')
            ->with('department')
            ->get();


        $selected = EmpProfessional::query()->where('company_id',$this->company_id)
            ->whereHas('trainees',function($query) use($schID){
                $query->where('training_schedule_id',$schID);
            })
            ->select('department_id',DB::raw('count(employee_id) as selected'))
            ->groupBy('department_id')
            ->get();

        return view('training.complete-schedule-after-training-index',compact('emp_count','training','selected'));
    }

    public function participantList($dId, $schId)
    {
        $emp_info = EmpProfessional::query()
            ->where('department_id',$dId)
            ->where('working_status_id',1)
            ->with('department')->with('personal')
            ->with('designation')
            ->get();

        $training = TrainingSchedule::query()->where('company_id',$this->company_id)
            ->where('id',$schId)
            ->with('training')
            ->first();

        $empSelected = Trainee::query()->where('company_id',$this->company_id)
        ->where('approval_status',true)
        ->where('status',true)
        ->whereNull('finalize_at')
        ->whereNull('evaluated_by')
         ->whereNotNull('approver_id')
            ->where('training_schedule_id',$schId)
            ->whereHas('employee',function($query) use($dId){
                $query->where('department_id',$dId);
            })
            ->get();


        return view('training.complete-attend-employee-training',compact('emp_info','training','empSelected'));
    }

    public function CompleteAttendList(Request $request)
    {
        $ids = $request->all();

        DB::beginTransaction();

        try {

            $data = $request['check'];

            for ($i=0; $i < count($ids['employee_id']); $i++)
            {
                $count = 0;
                foreach ($data as $item)
                {
                    if($item == $ids['employee_id'][$i])
                    {
                    Trainee::query()->where('company_id',$this->company_id)
                    ->where('training_schedule_id',$request['training_id'])
                    ->where('employee_id',$ids['employee_id'][$i])
                    ->update(['attended'=>true,'evaluation'=>$ids['evaluation'][$i],'finalize_at'=>Carbon::now(),
                  
                    'evaluated_by'=>$this->user_id]);

                        $count ++;
                    }
                }

                $training = TrainingSchedule::query()->where('id',$request['training_id'])->first();

                TrainingSchedule::query()->where('id',$request['training_id'])->increment('attended',$count);

                Training::query()->where('id',$training->training_id)->increment('attended',$count);

            }

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Training\CompleteTrainingController@index',$request['training_id'])->with('success','Data Data Updated');
    }
}
