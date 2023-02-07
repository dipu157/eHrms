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
use Yajra\DataTables\DataTables;
//use App\Http\Traits\TrainingsTrait;

class TrainingScheduleController extends Controller
{

//    use TrainingsTrait;

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
        if(check_privilege(62,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $trainings = Training::query()->where('company_id',$this->company_id)
            ->where('status',true)
            ->orderBy('title')
            ->pluck('title','id');

        return view('training.schedule-training-index',compact('trainings'));
    }


    public function scheduleData()
    {
        $trainings = TrainingSchedule::query()->where('company_id',$this->company_id)
            ->with('training')->get();


        return DataTables::of($trainings)

            ->addColumn('action', function ($trainings) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="scheduleView/'.$trainings->id.'"  type="button" class="btn btn-info btn-view btn-sm">View</button>

                    
                    <button data-remote="deleteSchedule/'.$trainings->id.'"  type="button" class="btn btn-training-delete btn-danger btn-sm"><i class="fa fa-trash"></i>Delete</button>
                    
                    <button data-remote="addTraineeIndex/'.$trainings->id.'"  type="button" class="btn btn-secondary btn-participant btn-sm"><i class="fa fa-plus"></i>Participant</button>
                    <button data-remote="completeTrainingIndex/'.$trainings->id.'"  type="button" class="btn btn-primary btn-complete btn-sm"><i class="fa fa-edit"></i>Complete</button>
                    
                    ';
            })

            ->addColumn('status', function ($trainings) {

                return $trainings->status == true ? 'Active' : 'Disabled';
            })

            ->addColumn('date-time', function ($trainings) {

                return $trainings->from_time. ' To '.$trainings->to_time ;
            })


            ->rawColumns(['action','status','date-time'])
            ->make(true);
    }

    public function create(Request $request)
    {
        if(check_privilege(62,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['status'] = true;
        $request['training_id'] = $request['title_id'];

        $request['start_from'] = Carbon::createFromFormat('d-m-Y H:i',$request['start_from']);
        $request['end_on'] = Carbon::createFromFormat('d-m-Y H:i',$request['end_on']);

        DB::beginTransaction();

        try {

            TrainingSchedule::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
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

        $training = TrainingSchedule::query()->where('company_id',$this->company_id)->where('id',$id)
            ->with('training')->first();

        $trainees = EmpProfessional::query()->where('company_id',$this->company_id)
            ->whereHas('trainees',function ($query) use ($id){
                $query->where('training_schedule_id',$id)
                ->where('trainees.approval_status','=',1)
                ->where('trainees.status','=',1)
                ->whereNotNull('trainees.finalize_at')
                ->whereNotNull('trainees.evaluated_by')
         ->whereNotNull('trainees.approver_id');
               
            })
            ->with('department')->with('personal')->with(['trainee'=>function($q) use($id) {
                $q->where('training_schedule_id',$id);
            }])
            ->orderBy('department_id')->get();

//        $participants = EmpProfessional::query()->where('company_id',$this->company_id)
//            ->whereHas('trainees',function($query) use($id){
//                $query->where('training_schedule_id',$id);
//            })
//            ->select('department_id',DB::raw('count(employee_id) as selected'))
//            ->with('department')
//            ->groupBy('department_id')
//            ->get();

        $participants = EmpProfessional::query()
                ->select('emp_professionals.department_id', DB::Raw('count(emp_professionals.employee_id) as participant'),
                    DB::Raw('sum(case when(trainees.attended = 1) then 1 else 0 end) as attended'),
                    DB::Raw('sum(case when(trainees.attended = 1) then 0 else 1 end) as absent')
                    )
                ->join('trainees', function ($join) use($id) {
                    $join->on('emp_professionals.employee_id', '=', 'trainees.employee_id')
                        ->where('trainees.training_schedule_id',$id);
                    })
                ->groupBy('emp_professionals.department_id')
                ->with('department')
                ->get();



//        $attends = EmpProfessional::query()->where('company_id',$this->company_id)
//            ->whereHas('trainees',function($query) use($id){
//                $query->where('training_schedule_id',$id)->where('attended',true);
//            })
//            ->select('department_id',DB::raw('count(employee_id) as selected'))
//            ->groupBy('department_id')
//            ->get();



        return view('training.view-schedule-training-index',compact('training','trainees','participants'));
    }

    public function printDetails($id,$time)
    {
        $training = TrainingSchedule::query()->where('company_id',$this->company_id)->where('id',$id)
            ->with('training')->first();

        $trainees = EmpProfessional::query()->where('company_id',$this->company_id)
            ->whereHas('trainees',function ($query) use ($id){
                $query->where('training_schedule_id',$id)->where('trainees.approval_status','=',1)
                ->where('trainees.status','=',1)
                ->whereNotNull('trainees.finalize_at')
                ->whereNotNull('trainees.evaluated_by')
         ->whereNotNull('trainees.approver_id');
            })
            ->with('department')->with('personal')->with(['trainee'=>function($q) use($id) {
                $q->where('training_schedule_id',$id);
            }])
            ->orderBy('department_id')->get();


        $participants = EmpProfessional::query()
            ->select('emp_professionals.department_id', DB::Raw('count(emp_professionals.employee_id) as participant'),
                DB::Raw('sum(case when(trainees.attended = 1) then 1 else 0 end) as attended'),
                DB::Raw('sum(case when(trainees.attended = 1) then 0 else 1 end) as absent')
            )
            ->join('trainees', function ($join) use($id) {
                $join->on('emp_professionals.employee_id', '=', 'trainees.employee_id')
                    ->where('trainees.training_schedule_id',$id)
                    ->where('trainees.approval_status','=',1)
                    ->where('trainees.status','=',1)
                    ->whereNotNull('trainees.finalize_at')
                    ->whereNotNull('trainees.evaluated_by')
             ->whereNotNull('trainees.approver_id');
             
            })
            ->groupBy('emp_professionals.department_id')
            ->with('department')
            ->get();


        $view = \View::make('training.print.print-training-details',compact('training','trainees','participants','time'));

        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(10, 5, 5,0);

        $pdf::AddPage('P');

        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output('trainingApprove.pdf');

        return;
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $training = TrainingSchedule::query()->where('id',$id)->first();

            Training::query()->where('id',$training->training_id)->decrement('participants',$training->participants);
            Training::query()->where('id',$training->training_id)->decrement('attended',$training->attended);

            Trainee::query()->where('training_schedule_id',$id)->delete();
            TrainingSchedule::query()->findOrFail($id)->delete();


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Training Schedule Deleted'], 200);

    }

}
