<?php

namespace App\Http\Controllers\Training;

use App\Models\Common\Department;
use App\Models\Employee\EmpProfessional;
use App\Models\Training\Trainee;
use App\Models\Training\Training;
use App\Models\Training\TrainingSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageParticipantController extends Controller
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

//        $departments = Department::query()->where('company_id',$this->company_id)
//            ->where('status',true)->get();

        $training = TrainingSchedule::query()->where('company_id',$this->company_id)
            ->where('id',$schID)
            ->with('training')
            ->first();

        $emp_count = EmpProfessional::query()->whereIn('working_status_id',[1,2,8])
            ->whereNotNull('department_id')
            ->select('department_id',DB::raw('count(id) as total'))
            ->groupBy('department_id')
            ->with('department')->get();


        $selected = EmpProfessional::query()->where('company_id',$this->company_id)
            ->whereHas('trainees',function($query) use($schID){
                $query->where('training_schedule_id',$schID);
            })
            ->select('department_id',DB::raw('count(employee_id) as selected'))
            ->groupBy('department_id')
            ->get();

        return view('training.add-participant-index',compact('emp_count','training','selected'));
    }

    public function traineeList(Request $request, $dId, $schId)
    {

        $emp_info = EmpProfessional::query()
            ->where('department_id',$dId)
            ->whereIn('working_status_id',[1,2,8])
            ->with('department')->with('personal')
            ->with('designation')
            ->get();

        $training = TrainingSchedule::query()->where('company_id',$this->company_id)
            ->where('id',$schId)
            ->with('training')
            ->first();

        $empSelected = Trainee::query()->where('company_id',$this->company_id)
            ->where('training_schedule_id',$schId)
            ->whereHas('employee',function($query) use($dId){
                $query->where('department_id',$dId);
            })
            ->get();


        return view('training.trainee-list-for-training-index',compact('emp_info','training','empSelected'));
    }

    public function traineePost(Request $request)
    {

        $emp_ids = $request['check'];
        
        DB::beginTransaction();

        try {
                 
            $request['company_id']= $this->company_id;
            $request['training_schedule_id']=$request['training_id'];
            
            $request['user_id']=Auth::id();

        //$divisions = Division::query()->where('company_id',$this->company_id)->pluck('start_from');
        // $starton =TrainingSchedule::query()
    // ->select(DB::raw('start_from')->where('company_id',$this->company_id)
    //->where('id',$request['training_schedule_id'])->get();
    //$training = TrainingSchedule::query()->where('company_id',$this->company_id)
    //->where('id',$request['training_id'])
    //->with('training')
    //->first();
           
            //dd($starton);


            $training=TrainingSchedule::query()->where('id',$request['training_id'])->first();

        $training_date=$training->start_from;
            
           // $training_date = Carbon::createFromFormat('d-m-Y H:i', $training->start_from)->format('Y-m-d');
        //dd($training_date);
        //$starton =  Carbon::createFromFormat('H:i:s',$training_date)->format('h:i');
            $employees = EmpProfessional::query()->where('department_id',$request['department_id'])->get();
            //dd($request['training_date']);
            // Delete the existing list for the department

            foreach ($employees as $emp)
            {
                Trainee::query()->where('company_id',$this->company_id)
                    ->where('training_schedule_id',$request['training_id'])
                    ->where('employee_id',$emp->employee_id)->delete();
            }

//            insert new selected employees

            foreach ($emp_ids as $item)
            {
                $request['employee_id']= $item;
                Trainee::query()->create($request->all());
            }
            Trainee::query()->where('company_id',$this->company_id)
            ->where('training_schedule_id',$request['training_id'])
            ->update(['training_date'=>$training_date]);

            $count = Trainee::query()->where('company_id',$this->company_id)
                ->where('training_schedule_id',$request['training_id'])
                ->count('employee_id');

               // dd($count);
                

//     Update No of Participants

            TrainingSchedule::query()->where('company_id',$this->company_id)
                ->where('id',$request['training_id'])->update(['participants'=>$count]);


            $training=TrainingSchedule::query()->where('id',$request['training_id'])->first();

            Training::query()->where('id',$training->training_id)->increment('participants',$count);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Training\ManageParticipantController@index',[$request['training_id']])->with('success','Trainee Data Added Successfully');
    }
}
