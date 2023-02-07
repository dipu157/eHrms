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

class AddTrainingController extends Controller
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
        if(check_privilege(61,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('training.training-index');
    }


    public function trainingData()
    {
        $trainings = Training::query()->where('company_id',1)
            ->where('status',true)
            ->get();


        return DataTables::of($trainings)

            ->addColumn('action', function ($trainings) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="view/'.$trainings->id.'"  type="button" class="btn btn-info btn-view btn-sm"><i class="fa fa-folder-open">View</i></button>
                    
                    <button data-remote="edit/' . $trainings->id . '" data-rowid="'. $trainings->id . '" 
                        data-title="'. $trainings->title . '" 
                        data-description="'. $trainings->description . '" 
                        type="button" href="#modal-edit-training" data-target="#modal-edit-training" data-toggle="modal" class="btn btn-sm btn-training-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                        
                        <button data-remote="printIndex/'.$trainings->id.'"  type="button" class="btn btn-secondary btn-print btn-sm"><i class="fa fa-print">Print</i></button>
                    </div>
                    
                    ';
            })

            ->addColumn('status', function ($trainings) {

                return $trainings->status == true ? 'Active' : 'Closed';
            })


            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function trainingindex()
    {
        if(check_privilege(61,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error',trans('message.permission'));
            die();
        }

        $trainings = TrainingSchedule::query()->where('company_id',$this->company_id)
        ->with('training')->get();

        $AgoDate=Carbon::now()->subWeek(+4)->format('Y-m-d');  
        $NowDate=Carbon::now()->format('Y-m-d');  
     
      // $month_id = Carbon::now()->format('m');
  
    //dd($AgoDate);
        $dept_id = Session::get('session_user_dept_id');

        $data = Trainee::query()->whereBetween('training_date',[$AgoDate,$NowDate])
        ->where('approval_status',false)
        ->where('status',true)
        ->whereNull('finalize_at')
        ->whereNull('finalize_by')
          ->whereHas('employee', function($q) use($dept_id) {
             $q->where('department_id',$dept_id);
                })
          ->with('employee')
          ->orderBy('training_date','desc')
        ->get();
        
 return view('training.apply_training_setup_index',compact('trainings','data'));
        
    }


    public function applytraining(Request $request)
    {
        if(check_privilege(61,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
       
        $request['status'] = true;

        DB::beginTransaction();

        try {

            Trainee::query()->create($request->all());

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return response()->json(['success' => 'New Apply Training Data Added'], 200);
    }
    public function finaltraining(Request $request)
    {
       

        if(check_privilege(54,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->orderBy('name')
            ->pluck('name','id');

            

        $dateRange = null;
        $department = null;

        if($request->has('department_id'))
        {
            

        $from = Carbon::createFromFormat('d-m-Y',$request['from_date'])->format('Y-m-d');
        $todate = Carbon::createFromFormat('d-m-Y',$request['to_date'])->format('Y-m-d');

        $dept_id = $request['department_id'];
        $department = Department::query()->where('company_id',$this->company_id)
        ->where('id',$dept_id)->first();

            $dateRange = createDateRange($from,getNextDay($todate));
/////
            $data = Trainee::query()->where('trainees.attended','=',0)
     
            ->with('approver')
            ->with('employee')
            ->whereHas('employee',function($query) use($dept_id) {
                $query->where('department_id',$dept_id);
            })
            ->join('emp_professionals', 'emp_professionals.employee_id', '=', 'trainees.employee_id')
            ->join('training_schedules', 'trainees.training_schedule_id', '=', 'training_schedules.id')
            ->join('trainings', 'training_schedules.training_id', '=', 'trainings.id')
                           
            ->whereBetween('trainees.training_date',[$from,$todate])
                ->where('trainees.approval_status','=',0)->where('trainees.status','=',1)
            
                ->orderBy('trainees.training_date','trainees.employee_id','ASC')
             
            ->get();
//            dd($dates);

       
//dd($data);  
//dd($data);
//            foreach ($data as $row)
//            {
//
//            }

            return view('training.monthly_training_index',compact('departments','data','dateRange','department'));
        }

        return view('training.monthly_training_index',compact('departments','dateRange'));
    }


    public function create(Request $request)
    {
        if(check_privilege(61,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;

        DB::beginTransaction();

        try {

            Training::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return response()->json(['success' => 'New Training Data Added'], 200);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try {

            Training::query()->where('id',$request['id-for-update'])->update($request->except('_token','id-for-update'));


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return response()->json(['success' => 'Training Data Updated'], 200);
    }

    public function view($id)
    {
        $training = Training::query()->where('company_id',1)->where('id',$id)
            ->with('trainingSchedule')
            ->first();


        return view('training.view-training',compact('training'));
    }

    public function printTrainingIndex($id)
    {

        $training = Training::query()->where('id',$id)->first();

        $dept_data = EmpProfessional::query()->where('company_id',$this->company_id)
            ->where('working_status_id',1)
            ->selectRaw('department_id, count(*) as t_emp')
            ->with('department')
            ->groupBy('department_id')->get();


        $traineeList = Trainee::query()->where('company_id',$this->company_id)->where('attended',true)
            ->with('trainingSch')
            ->whereHas('trainingSch',function($query) use($id) {
                $query->where('training_id',$id);
            })->get();


        $trainees = Collect();

        foreach ($traineeList as $row)
        {
            $dept = EmpProfessional::query()->where('company_id',$this->company_id)
                ->where('employee_id',$row->employee_id)->first();

            $row['department_id']= $dept->department_id;
            $row['training_id'] = $row->trainingSch->training_id;

            $trainees->push($row);
        }

//        dd($trainees);

        $final = Collect();

        foreach ($dept_data as $dept)
        {
            $count = 0;
            foreach ($trainees as $person)
            {
                if($dept->department_id == $person->department_id)
                {
                    $count ++;
                }
            }

            $dept['attended'] = $count;

            $final->push($dept);
        }

//        dd($final);


        return view('training.report.training-main-index',compact('training','final'));
    }

    public function printTraining($tid, $did)
    {

//        dd($tid);

        $training = Training::query()->where('company_id',$this->company_id)->where('id',$tid)
            ->first();

 //$id = $request['training_id'];

 //$status_id = $request['status_id'];

 //$dept_id = $did;


        $traineeList = Trainee::query()->where('company_id',$this->company_id)->where('attended',true)
            ->with('trainingSch')
            ->whereHas('trainingSch',function($query) use($tid) {
                $query->where('training_id',$tid);
            })
            ->with('employee')
            ->whereHas('employee',function($query) use($did) {
                $query->where('department_id',$did);
            })
            ->get();

        $emp_list = EmpProfessional::query()->where('company_id',$this->company_id)
            ->where('working_status_id',1)->where('department_id',$did)
            ->get();



dd($traineeList);



//        $train = Trainee::query()->where('training_schedule_id',4)
//            ->get();

//        dd($train);


//        $dates = TrainingSchedule::query()->where('company_id',$this->company_id)->where('training_id',$id)->get();
//
//
//        $info = DB::Table('trainees')
//            ->join('training_schedules', 'training_schedules.id', '=', 'trainees.training_schedule_id')
//            ->join('trainings', 'trainings.id', '=', 'training_schedules.training_id')
//            ->join('emp_professionals','emp_professionals.employee_id','=','trainees.employee_id')
//            ->join('emp_personals','emp_personals.id','=','emp_professionals.emp_personals_id')
//            ->select('trainees.*', 'trainings.title', 'emp_personals.full_name')
//            ->get();
//
//
//        $emp_data = DB::Table('emp_professionals')
//            ->leftJoin('trainees','emp_professionals.employee_id','=','trainees.employee_id')
//            ->leftJoin('training_schedules','training_schedules.id','=','trainees.training_schedule_id')
//            ->leftJoin('trainings','trainings.id','=','training_schedules.training_id')
//            ->join('emp_personals','emp_personals.id','=','emp_professionals.emp_personals_id')
//            ->select('trainings.title','emp_professionals.*','emp_personals.full_name','trainees.attended','training_schedules.start_from')
//            ->where('trainings.id',$id)
//            ->get();

//        $emp_data = EmpProfessional::query()->where('company_id',$this->company_id)
//            ->where('working_status_id',1)->where('department_id',$request['department_id'])
//            ->get();

//        $trainings = TrainingSchedule::query()->where('company_id',$this->company_id)
//            ->with(['trainees'=>function($query) use($id) {
//                $query->where('attended', true);
//            }])
//            ->where('training_id',$id)
//            ->get();


//        $emp_data = DB::Select("select emr.employee_id, emp.full_name, dg.name, trs.start_from
//        from emp_professionals emr
//        join emp_personals emp on emp.id = emr.emp_personals_id
//        LEFT OUTER JOIN trainees tr on emr.employee_id = tr.employee_id
//        LEFT OUTER JOIN training_schedules trs on trs.id = tr.training_schedule_id
//        join designations dg on dg.id = emr.designation_id
//        where emr.department_id = '$dept_id' and trs.training_id = '$id'");

//        dd($data);

//        foreach ($emp_data as $emp)
//        {
//            $emp_data->where('employee_id',$emp->employee_id)->push(['test'=>'test']);
//            if($trainings->contains('trainees.employee_id',$emp->employee_id))
//            {
//                $date = $trainings->where('trainees.employee_id',$emp->employee_id)->first();
//                $emp['trained_date'] = '25-04-2019';
//            }else{
//                $emp['trained_date'] = '';
//            }
//
//            $emp['test']= 'test';
//        }


//        dd($emp_data);


//        $department = Department::query()->where('company_id',$this->company_id)->where('id',$request['department_id'])->first();


        $view = \View::make('training.print.print-training-main',compact('traineeList','emp_list','training'));

        $html = $view->render();


//        $original_mem = ini_get('memory_limit');

// then set it to the value you think you need (experiment)
//        ini_set('memory_limit','4048M');

//        ini_set('max_execution_time', 900);
//        session_start();
// create new PDF document
//        $test_mem = ini_get('memory_limit');

//        dd($test_mem);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(10, 5, 5,0);

        $pdf::AddPage('P');

        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output('training.pdf');

//        ini_set('memory_limit',$original_mem);

        return;

    }
}
