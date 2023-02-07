<?php

namespace App\Http\Controllers\Employee;

use App\Exports\EmployeeExport;
use App\Models\Common\Bank;
use App\Models\Common\Department;
use App\Models\Common\DoctorDepartment;
use App\Models\Common\Division;
use App\Models\Common\Religion;
use App\Models\Common\Section;
use App\Models\Common\WorkingStatus;
use App\Models\Company\Bangladesh;
use App\Models\Company\Company;
use App\Models\Employee\Designation;
use App\Models\Employee\BaseDesignation;
use App\Models\Employee\EmpDependant;
use App\Models\Employee\EmpEducational;
use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpPostingHistory;
use App\Models\Employee\EmpProfessional;
use App\Models\Employee\EmpPromotion;
use App\Models\Employee\EmpHistory;
use App\Models\Employee\EmpRecomended;
use App\Models\Employee\Punish;
use App\Models\Employee\JobStatusHistory;
use App\Models\Employee\Title;
use App\Models\Leaves\LeaveApplication;
use App\Models\Attendance\PublicHoliday;
use App\Models\Leaves\LeaveMaster;
use App\Models\Leaves\LeaveRegister;
use App\Models\Attendance\DailyAttendance;
use App\Models\Training\Trainee;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use TCPDF_FONTS;

class EmployeeController extends Controller
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

        if(check_privilege(18,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $titles = Title::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');
        $sections = Section::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');
        $banks = Bank::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');

        $districts = Bangladesh::query()->where('lang','en')->distinct()->orderBy('district')->pluck('district','district');
        $posts = Bangladesh::query()->where('lang','en')->orderBy('post_code')->pluck('post_code','post_code');
        $religions = Religion::query()->pluck('name','id');

        $dhaka = Bangladesh::query()->where('id',49)->first();
        $company = Company::query()->where('id',1)->first();

        return view('employee.employee-index',compact('titles','departments','sections','designations','banks','districts','posts','religions','dhaka','company'));
    }

    public function employeeData()
    {

        $first = EmpPersonal::query()->whereDoesntHave('professional');

        $employees = EmpPersonal::query()->where('company_id',1)
            ->with('professional')->with('user')
            ->get();

        return DataTables::of($employees)

            ->addColumn('action', function ($employees) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$employees->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>
                    <button data-remote="edit/'. $employees->id . '" 
                        type="button" class="btn btn-sm btn-employee-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    <button data-remote="employee/photo/'.$employees->id.'" data-rowid="'. $employees->id . '"   type="button" class="btn btn-photo-sign btn-sm btn-secondary"><i class="fa fa-open">Image</i></button>
                    <button data-remote="education/'.$employees->id.'" data-rowid="'. $employees->id . '"   type="button" class="btn btn-education btn-sm btn-info"><i class="fa fa-open">Education</i></button>
                    <button data-remote="appLetter/'.$employees->id.'"  data-rowid="'. $employees->id . '" type="button" class="btn btn-appLetter btn-sm btn-primary"><i class="fa fa-open">Personal</i></button>
                    <button data-remote="recomended/'.$employees->id.'"  data-rowid="'. $employees->id . '" type="button" class="btn btn-recomended btn-sm btn-primary"><i class="fa fa-open">Recomended</i></button>
                    </div>
                    <br/>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    
                    <button data-remote="history/'.$employees->id.'" data-rowid="'. $employees->id . '"   type="button" class="btn btn-history btn-sm btn-amber"><i class="fa fa-open">History</i></button>
                    <button data-remote="posting/'.$employees->id.'"  data-rowid="'. $employees->id . '" type="button" class="btn btn-posting btn-sm btn-info"><i class="fa fa-open">Posting</i></button>
                    <button data-remote="promotion/'.$employees->id.'"  data-rowid="'. $employees->id . '" type="button" class="btn btn-promotion btn-sm btn-default"><i class="fa fa-open">Promotion</i></button>
                    <button data-remote="idcard/'.$employees->id.'"  data-rowid="'. $employees->id . '" type="button" class="btn btn-idcard btn-sm btn-danger"><i class="fa fa-open">Card</i></button>
                    <button data-remote="punish/'.$employees->id.'"  data-rowid="'. $employees->id . '" type="button" class="btn btn-punish btn-sm btn-danger"><i class="fa fa-open">Punish</i></button>
                    </div>
                    ';
            })

            ->addColumn('status', function ($employees) {

                return $employees->status == true ? 'Active' : 'Disabled';
            })

            ->addColumn('emp_id', function ($employees) {

                return isset($employees->professional->employee_id) ? $employees->professional->employee_id . '<br/> <span style="color: #7d0000">' . $employees->professional->wStatus->name .'</span>' : '';
            })

            ->addColumn('designation', function ($employees) {

                return isset($employees->professional->designation_id) ? $employees->professional->designation->name . '<br/> <span style="color: #0c5460">'.$employees->professional->department->name .'</span>' : '';
            })

            ->editColumn('showimage', function ($employees) {
                if (!isset($employees->photo)) {
                    return "Photo";
                }
                return '<img src="' . asset($employees->photo) .
                    '" alt=" " style="height: 50px; width: 50px;" >';
            })

            ->rawColumns(['action','status','showimage','designation','emp_id'])
            ->make(true);
    }

    public function view($id)
    {

        $emp_info = EmpPersonal::query()->where('id',$id)
            ->with('dependant')->with('title')
            ->with('professional')->with('leaveApp')
            ->with('education')->with('posting')
            ->first();

        return view('employee.view-employee-details',compact('emp_info'));
    }

    public function appLetter($id)
    {
            $employe_id = EmpProfessional::query()->where('emp_personals_id',$id)->pluck('employee_id');
       
            $employees = EmpProfessional::query()
                        ->where('company_id',$this->company_id)
                        ->where('employee_id',$employe_id)
                        ->first();

            $emp_leaves = LeaveMaster::query()->where('company_id',$this->company_id)->get();

            $l_year = 2021;


            $emp_yearly_leave = LeaveRegister::query()
                                ->where('emp_personals_id',$id)
                                ->where('leave_year',$l_year)
                                ->with('type')
                                ->get();


            $g_holidays = PublicHoliday::query()->where('company_id',$this->company_id)
                                      ->where('hYear',$l_year)
                                      ->pluck('from_date');

            $g_holidays_day = PublicHoliday::query()->where('company_id',$this->company_id)
                                      ->where('hYear',$l_year)
                                      ->select(DB::raw("SUM(count) as gholidays"))
                                      ->pluck('gholidays');

            $g_holidayCont = PublicHoliday::query()->where('company_id',$this->company_id)
                            ->where('hYear',$l_year)
                            ->pluck('count');

            $g_holidaysday = PublicHoliday::query()->where('company_id',$this->company_id)
                            ->where('hYear',$l_year)
                            ->select(DB::raw("count(count) as gholidays"))
                            ->pluck('gholidays');


                            
                            $join_date = $employees->joining_date;
                            $end = '2021-12-31';

                            $join_date_str = strtotime($join_date);
                            $join_date_day = date("d", $join_date_str);
                            $join_month_days = Carbon::parse($join_date)->daysInMonth;
                            $join_month_work = $join_month_days - $join_date_day;

                            $w_months = nb_mois($join_date,'2021-12-31');

                            $join_day=Carbon::parse($join_date);

                            $process_day=Carbon::parse('2021-12-31');

                            $w_day=$join_day->diffInDays($process_day);

                            $count = 0;

                            $slength = $w_months/12; 

                           // dd($g_holidays);


                            //dd($g_holidaysday[0]);

                            for ($i=0; $i<$g_holidaysday[0]; $i++) {

                                if($g_holidays[$i] > $join_date){

                                    break;
                                }
                                else
                                {
                                    $count += $g_holidayCont[$i];
                                }
                            }       

                            //dd($count);                  

                            $total_gdays = $g_holidays_day[0] - $count ;

                            if($w_months >= 12){

                                $total_wDays = 366;
                                $total_wHolidays = 52;
                                $total_gHolidays = $g_holidays_day[0];
                            }else{

                                $total_wDays = $w_day+1;
                                // $total_wHolidays = round($total_wDays/7);
                                $total_wHolidays = dayCount($join_date,'2021-12-31',5);
                                $total_gHolidays = $total_gdays;
                            }

                        //dd($total_wDays);

                        $data = DailyAttendance::query()
                                ->where('company_id',$this->company_id)
                                ->whereBetween('attend_date',['2021-01-01','2021-12-31'])
                                ->where('employee_id',$employe_id)
                                ->select('employee_id',

                                    DB::raw('sum(case when leave_id = 9 then 1 else 0 end) as wpLeave'),
                                    DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
                                )
                                ->with('professional')       
                                ->first();

            $punish = Punish::query()
                        ->where('emp_personals_id',$id)
                        ->whereBetween('effective_date',['2021-01-01','2021-12-31'])
                        ->where('status',true)
                        ->get();

                       // dd($punish);

                          

        $view = \View::make('employee.report.print.pdf_personal_information',  compact('employees','data','emp_yearly_leave','l_year','total_wDays','total_wHolidays','total_gHolidays','punish','end'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('personal_information.pdf');
    }

    public function punish($id)
    {

        $emp_data = EmpPersonal::query()->where('id',$id)->first();

        $department_id = EmpProfessional::query()
                        ->where('company_id',$this->company_id)
                        ->where('emp_personals_id',$id)
                        ->pluck('department_id');

        $dept_id = Department::query()
                        ->where('company_id',$this->company_id)
                        ->where('id',$department_id)
                        ->first();

       // dd($emp_data);

        return view('employee.employee-punish-index',compact('id','emp_data','dept_id'));
    }

    public function punishPost(Request $request)
    {

        DB::beginTransaction();

        try {

            $request['emp_personals_id'] = $request['employee_p_id'];
            $request['punish_id'] = $request['punish_id'];
            $request['department_id'] = $request['department_id'];
            $request['descriptions'] = $request['descriptions'];
            $request['effective_date'] = Carbon::createFromFormat('d-m-Y',$request['effective_date'])->format('Y-m-d');
            $request['company_id'] = $this->company_id;
            $request['user_id'] = $this->user_id;
            $request['status'] = true;

        Punish::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return redirect()->back()->with('error',$error);
        }

        DB::commit();

        return redirect()->action('Employee\EmployeeController@index')->with('success','Employee Punish SetUp Successfully');
    }

    public function create(Request $request)
    {



        if(check_privilege(18,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        dd($request);


        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['title_id'] = 1;

//        dd($request);

        switch ($request['action'])
        {
            case 'personal':

                $request['dob'] = Carbon::createFromFormat('Y-m-d',$request['dob']);
                $request['full_name'] = $request['first_name'].' '.$request['middle_name'].' '.$request['last_name'];

//        dd($request);

                DB::beginTransaction();

                try {

                    $data = EmpPersonal::create($request->all());


                    $leaves = LeaveMaster::query()->where('company_id',$this->company_id)->where('status',true)->get();

                    foreach ($leaves as $row)
                    {
                        LeaveRegister::query()->insert([
                            'company_id'=>$this->company_id,
                            'leave_year'=> Carbon::now()->format('Y'),
                            'leave_eligible' =>$row['yearly_limit'],
                            'emp_personals_id'=>$data->id,
                            'leave_id'=>$row->id
                        ]);
                    }


                }catch (\Exception $e)
                {
                    DB::rollBack();
                    $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
                    return response()->json(['error' => $error], 404);
                }

                DB::commit();

                break;

            case 'official':

                $request['joining_date'] = Carbon::createFromFormat('Y-m-d',$request['joining_date']);
                $request['full_name'] = $request['first_name'].' '.$request['middle_name'].' '.$request['last_name'];
                $a = $request['confirm_probation'] ;
                //$request['working_status_id'] = $a;
                $request['working_status_id'] = ($a === 'P' ? 2 : 8);
                $request['effective_date'] = $request['joining_date'];
                $request['descriptions'] = 'Designated by joining';

        // http_response_code(500);
        // echo json_encode($a);

                DB::beginTransaction();

                try {

                    $data = EmpProfessional::query()->create($request->all());
                    EmpPromotion::query()->create($request->all());

                }catch (\Exception $e)
                {
                    DB::rollBack();
                    $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
                    return response()->json(['error' => $error], 404);
                }

                DB::commit();

                break;
        }

        return json_encode($data);
    }

    public function empInfoForEdit($id)
    {
        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = EmpPersonal::query()->where('company_id',1)->where('id',$id)
            ->with('title')->with('professional')->first();

        $titles = Title::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $doctorDepartments = DoctorDepartment::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $sections = Section::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)->orderBy('name','ASC')->pluck('name','id');
        $base_designations = BaseDesignation::query()->where('company_id',$this->company_id)
            ->where('status',true)->orderBy('name','ASC')->pluck('name','id');
        $banks = Bank::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');

        $districts = Bangladesh::query()->where('lang','en')->distinct()->orderBy('district')->pluck('district','district');
        $posts = Bangladesh::query()->where('lang','en')->orderBy('post_code')->pluck('post_code','post_code');
        $religions = Religion::query()->pluck('name','id');
        $working = WorkingStatus::query()->where('company_id',$this->company_id)->pluck('name','id');

        return view('employee.edit-employee-data',compact('data','titles','doctorDepartments','base_designations','departments','sections','designations','banks','districts','posts','religions','working'));

    }


    public function updateImage(Request $request)
    {
        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {


            $card_no = EmpProfessional::query()->where('emp_personals_id',$request['phoro_emp_id'])->first();

            if($request->hasfile('photo-image'))
            {
                $file = $request->file('photo-image');




                $name = $card_no->employee_id.'.'.$file->getClientOriginalExtension();
                $file->move(public_path().'/photo/', $name);

                EmpPersonal::query()->find($request['phoro_emp_id'])->update(['photo'=>'photo/'.$name]);
            }

            if($request->hasfile('sign-image'))
            {
                $file = $request->file('sign-image');

                $name = $card_no->employee_id.'.'.$file->getClientOriginalExtension();
                $file->move(public_path().'/sign/', $name);

                EmpPersonal::query()->find($request['phoro_emp_id'])->update(['signature'=>'sign/'.$name]);
            }



        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Employee\EmployeeController@index')->with('success','Successful');

    }


    public function update(Request $request)
    {
//        dd($request);

        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
//        dd($request);

        DB::beginTransaction();

        try {

            if($request->has('action'))
            {
                switch ($request['action'])
                {
                    case   'personal':

                        DB::beginTransaction();

                        try {
                            $request['full_name'] = $request['first_name'].' '.$request['middle_name'].' '.$request['last_name'];
                            EmpPersonal::query()->where('id',$request['id'])->update($request->except(['_token','action']));


                        }catch (\Exception $e)
                        {
                            DB::rollBack();
                            $error = $e->getMessage();
                            return response()->json(['error' => $error], 404);
                        }

                        DB::commit();


                    break;

                    case   'professional':

                        DB::beginTransaction();

                        try {


                            $flight = EmpProfessional::query()->updateOrCreate(
                                ['employee_id' => $request['employee_id'], 'emp_personals_id' => $request['emp_personals_id']],
                                [
                                    'company_id'=>$this->company_id,
                                    'pf_no' => $request['pf_no'],
                                    'doctor_department_id' => $request['doctor_department_id'],
                                    'base_designation_id'  => $request['base_designation_id'],
                                    'designation_id'  => $request['designation_id'],
                                    'joining_date' => $request['joining_date'],
                                    'report_to' => $request['report_to'],
                                    'bank_id' => $request['bank_id'],
                                    'bank_acc_no' => $request['bank_acc_no'],
                                    'overtime' => $request['overtime'],
                                    'overtime_note' => $request['overtime_note'],
                                    'doctor_special_id' => $request['doctor_special_id'],
                                    'confirm_probation' => $request['confirm_probation'],
                                    'confirm_period' => $request['confirm_period'],
                                    'card_no' => $request['card_no'],
                                    'working_status_id' => $request['confirm_probation'] == 'P' ? 2 : $request['working_status_id'],
                                    'transport' => $request['transport'],
                                    'punch_exempt' => $request['punch_exempt'],
                                    'late_exempt' => $request['late_exempt'],
                                    'status' => $request['status'],
                                    'transport_note' => $request['transport_note'],
                                    'user_id' =>$this->user_id
                                    ]
                            );

                            $promotion = EmpPromotion::query()->updateOrCreate(
                                ['emp_personals_id' => $request['emp_personals_id']],
                                [
                                    'company_id'=>$this->company_id,
                                    'effective_date' =>$request['joining_date'],
                                    'designation_id' =>$request['designation_id'],
                                    'descriptions' => 'Joining With This Designation',
                                    'user_id' =>$this->user_id
                            ]);


//                            $request['start_date'] = $request['joining_date'];
//                            $request['end_date'] = getPreviousDay($request['start_date']);

                            JobStatusHistory::query()->firstOrCreate(
                                ['emp_personals_id' => $request['emp_personals_id'],'status_id'=>$request['working_status_id']],
                                ['company_id'=>$this->company_id,
                                'start_date' => $request['joining_date'],
                                'change_notes'=>'New Join',
                                'user_id' =>$this->user_id
                            ]);

                        }catch (\Exception $e)
                        {
                            DB::rollBack();
                            $error = $e->getMessage();
                            return response()->json(['error' => $error], 404);
                        }

                        DB::commit();

                    break;

                    case 'job-status':

                        DB::beginTransaction();

                        try {

                            $request['company_id'] = $this->company_id;
                            $request['user_id'] = $this->user_id;
                            $request['start_date'] = Carbon::createFromFormat('Y-m-d',$request['start_date'])->format('Y-m-d');
                            $request['end_date'] = getPreviousDay($request['start_date']);

                            JobStatusHistory::query()->where('emp_personals_id',$request['emp_personals_id'])
                                ->whereNull('end_date')->update(['end_date'=>$request['end_date']]);

                            JobStatusHistory::query()->insert([
                                'emp_personals_id' => $request['emp_personals_id'],
                                'company_id'=>$this->company_id,
                                'status_id' => $request['status_id'],
                                'start_date' => $request['start_date'],
                                'change_notes'=>'New Join',
                                'user_id' =>$this->user_id
                            ]);

                            EmpProfessional::query()->where('id',$request['id'])->update(['working_status_id'=>$request['status_id'],'status_change_date'=>$request['start_date']]);

                        }catch (\Exception $e)
                        {
                            DB::rollBack();
                            $error = $e->getMessage();
                            return response()->json(['error' => $error], 404);
                        }

                        DB::commit();

                }


            }

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

//        return json_encode($data);

        return response()->json(['success' => 'Updated Employee Data'], 200);

    }

    public function history($id)
    {
        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = EmpPersonal::query()->where('company_id',1)->where('id',$id)
            ->with('title')->with('professional')->first();

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)->orderBy('name','ASC')->pluck('name','id');

        $emp_data = EmpPersonal::query()->where('id',$id)->first();

        return view('employee.employee-history',compact('emp_data','departments','designations','data'));
    }

    public function historyTableData($id)
    {
        $histories = EmpHistory::query()
                    ->where('company_id',1)
                    ->where('emp_personals_id',$id)
                    ->with('department')
                    ->with('designation')
                    ->get();

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)->orderBy('name','ASC')->pluck('name','id');


        return DataTables::of($histories)

            ->addColumn('action', function ($histories) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-rowid="'. $histories->id . '"
                        data-department="'. $histories->department_d . '"
                        data-designation="'. $histories->designation_id . '"
                        data-descriptions="'. $histories->descriptions . '"
                        type="button" href="#modal-update-history" data-target="#modal-update-history" data-toggle="modal" class="btn btn-sm btn-history-edit btn-primary pull-left"><i class="fa fa-edit" >Edit</i></button>
                        
                        <button data-remote="delete/' . $histories->id . '" type="button" class="btn btn-sm btn-history-delete btn-danger pull-right"><i class="fa fa-trash" >Delete</i></button>
                    </div>
                    ';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }


    public function educationIndex($id)
    {
        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $emp_data = EmpPersonal::query()->where('id',$id)->first();
        return view('employee.employee-education',compact('emp_data'));
    }

    public function educationTableData($id)
    {
        $educations = EmpEducational::query()->where('company_id',1)->where('emp_personals_id',$id)->get();


        return DataTables::of($educations)

            ->addColumn('action', function ($educations) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-rowid="'. $educations->id . '"
                        data-name="'. $educations->name . '"
                        data-type="'. $educations->degree_type . '"
                        data-institution="'. $educations->institution . '"
                        data-year="'. $educations->passing_year . '"
                        data-description="'. $educations->description . '"
                        data-result="'. $educations->result . '"
                        data-achievement="'. $educations->achievement_date . '"
                        type="button" href="#modal-update-education" data-target="#modal-update-education" data-toggle="modal" class="btn btn-sm btn-education-edit btn-primary pull-left"><i class="fa fa-edit" >Edit</i></button>
                        
                        <button data-remote="delete/' . $educations->id . '" type="button" class="btn btn-sm btn-education-delete btn-danger pull-right"><i class="fa fa-trash" >Delete</i></button>
                    </div>
                    ';
            })

            ->make(true);
    }

    public function educationSave(Request $request)
    {

        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;
        $request['achievement_date'] = $request->filled('achievement_date') ? Carbon::createFromFormat('Y-m-d',$request['achievement_date']) : null;
        $request['status'] = true;
        $request['emp_personals_id'] = $request['n_education_emp_id'];

        DB::beginTransaction();

        try {

            $data = EmpEducational::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Added Education Data'], 200);

    }

    public function educationUpdate(Request $request)
    {
        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return response()->json(['success' => 'You Have No Permission'], 200);
            die();
        }

        DB::beginTransaction();

        try {

            EmpEducational::query()->find($request['id'])->update($request->except('_token','id'));


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Education Data Updated'], 200);

    }

    public function educationDestroy($id)
    {
        if(check_privilege(18,4) == false) //2=show Division  1=view
        {
            return response()->json(['error' => 'You Have No Permission'],  404);
            die();
        }

        DB::beginTransaction();

        try {

            EmpEducational::query()->where('id',$id)->delete();

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();

//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return response()->json(['error' => $error], 404);


        }

        DB::commit();

        return response()->json(['success' => 'Education Data Deleted'], 200);
    }

    public function saveHistory(Request $request)
    {        

        $effective_date = $request->filled('effective_date') ? Carbon::createFromFormat('d-m-Y',$request['effective_date']) : null;

        DB::beginTransaction();

        try {

            $request['company_id'] = $this->company_id;            
            $request['emp_personals_id'] = $request['n_history_emp_id'];
            $request['employee_id'] = $request['employee_id'];
            $request['department_id'] = $request['department_id'];
            $request['designation_id'] = $request['designation_id'];
            $request['effective_date'] = $effective_date;
            $request['basic'] = $request['basic'];
            $request['gross_salary'] = $request['gross_salary'];
            $request['description'] = $request['description'];
            $request['user_id'] = $this->user_id;

            EmpHistory::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Added Employee History Data'], 200);

    }

    public function postingIndex($id)
    {
        $emp_data = EmpPersonal::query()->where('id',$id)->first();
        $divisions = Division::query()->where('company_id',1)->pluck('name','id');
        $departments = Department::query()->where('company_id',1)->orderBy('name','ASC')->pluck('name','id');
        $sections = Section::query()->where('company_id',1)->orderBy('name','ASC')->pluck('name','id');

        return view('employee.posting-employee',compact('emp_data','divisions','departments','sections'));
    }

    public function postingTableData($id)
    {
        $postings = EmpPostingHistory::query()->where('company_id',1)
            ->where('emp_personals_id',$id)
            ->with('division')
            ->with('department')
            ->with('section')
            ->get();


        return DataTables::of($postings)



            ->addColumn('action', function ($postings) {

                $report_to = EmpPersonal::query()->where('id',$postings->report_to)->first();

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="edit/' . $postings->id . '" data-rowid="'. $postings->id . '"
                        data-division="'. $postings->division_id . '"
                        data-department="'. $postings->department_id . '"
                        data-section="'. $postings->section_id . '"
                        data-boss="'. $report_to->full_name . '"
                        
                        data-start-date="'. $postings->posting_start_date . '"
                        data-charge="'. $postings->charge_type . '"
                        data-special="'. $postings->special . '"
                        data-note = "'. $postings->posting_notes . '"
                        data-emp-id = "'. $postings->emp_personals_id . '"
                        
                        type="button" href="#posting-update-modal" data-target="#posting-update-modal" data-toggle="modal" class="btn btn-sm btn-posting-edit btn-primary pull-left"><i class="fa fa-edit" >Edit</i></button>
                        
                        <button data-remote="delete/' . $postings->id . '" type="button" class="btn btn-sm btn-posting-delete btn-danger pull-right"><i class="fa fa-trash" >Delete</i></button>
                    </div>
                    ';
            })

            ->addColumn('charge', function ($postings) {

                return $postings->charge_type == 'I' ? 'Incharge' : ($postings->charge_type == 'S' ? '2nd Man' : 'General');
            })
            ->rawColumns(['action','charge'])
            ->make(true);
    }

    public function postingSave(Request $request)
    {

//        dd($request);

        DB::beginTransaction();

        try {

            $request['company_id'] = $this->company_id;
            $request['user_id'] = $this->user_id;
            $request['emp_personals_id'] = $request['n_posting_emp_id'];
            $request['report_to'] = $request['to_id'];
            $request['posting_start_date'] = Carbon::createFromFormat('Y-m-d',$request['effective_date']);
            $request['status'] = true;

            $id = EmpPostingHistory::query()->create($request->all());

            EmpProfessional::query()->where('emp_personals_id',$request['n_posting_emp_id'])
                ->update(['division_id'=>$request['division_id'],'department_id'=>$request['department_id'],
                    'section_id'=>$request['section_id'],'report_to'=>$request['report_to']]);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Added Posting Data'], 200);

    }

    public function postingUpdate(Request $request)
    {


        DB::beginTransaction();

        try {

            EmpPostingHistory::query()->where('id',$request['posting_id'])
                ->update($request->except(['_token','posting_id','report']));

            EmpProfessional::query()->where('emp_personals_id',$request['emp_personals_id'])
                ->update([
                    'division_id'=>$request['division_id'],'department_id'=>$request['department_id'],
                    'section_id'=>$request['section_id'],'report_to'=>$request['report_to']
                ]);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Posting Data Updated'], 200);
    }

    public function postingDelete()
    {
        return view('partials.underconstruction');
    }

    public function promotion($id)
    {

        $designations = Designation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')
            ->pluck('name','id');

        $emp_data = EmpPersonal::query()->where('id',$id)->first();

        return view('employee.employee-promotion-index',compact('id','designations','emp_data'));
    }

    public function promotionPost(Request $request)
    {

        DB::beginTransaction();

        try {

            $request['emp_personals_id'] = $request['employee_p_id'];
            $request['effective_date'] = Carbon::createFromFormat('d-m-Y',$request['effective_date'])->format('Y-m-d');
            $request['company_id'] = $this->company_id;
            $request['user_id'] = $this->user_id;
            $request['status'] = true;


            EmpPromotion::query()->where('company_id',$this->company_id)
                ->where('emp_personals_id',$request['employee_p_id'])
                ->where('status',true)->update(['status'=>false]);

            EmpPromotion::query()->create($request->all());

            EmpProfessional::query()->where('company_id',$this->company_id)
                ->where('emp_personals_id',$request['employee_p_id'])
                ->update(['designation_id'=>$request['designation_id']]);

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return redirect()->back()->with('error',$error);
        }

        DB::commit();

        return redirect()->action('Employee\EmployeeController@index')->with('success','Employee Successfully Promoted');
    }

    public function card_print(Request $request)
    {

        $data = EmpPersonal::query()->where('id',$request['emp_id_card'])
            ->with('professional')
            ->first();


        switch ($request['action'])
        {
            case 'front':


                $view = \View::make('employee.pdf-card-front-index',compact('data'));
                $html = $view->render();

                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(54,86), true, 'UTF-8', false);

                $fontname = TCPDF_FONTS::addTTFfont('font/blogger-sans.bold.ttf', 'TrueTypeUnicode', '', 32);
                $pdf::SetFont($fontname, '', 14, '', false);


                $pdf::setCellPaddings(0,0,0,0);
                $pdf::SetMargins(0, 0, 0,0);

                $pdf::SetAutoPageBreak(TRUE, 0);


                $pdf::AddPage();

                // for direct print

                $img_file = 'cardphoto/head.png';
                $pdf::Image($img_file, 5, 5, 175, 35, '', '', '', false, 300, '', false, false, 0);

                $img_file = $data->photo;
//                $pdf::Image($img_file, 15, 45, 155, 144, '', '', '', false, 300, '', false, false, 0); //for soft photo
                $pdf::Image($img_file, 30, 45, 120, 144, '', '', '', false, 300, '', false, false, 0); // for scan photo


                $img_file = 'cardphoto/cardfooter.png';
                $pdf::Image($img_file, 0, 167, 181, 122, '', '', '', false, 300, '', false, false, 0);


                $pdf::writeHTML($html, true, false, true, false, '');


                $pdf::Output('idcard.pdf');

                break;

            case 'back':



                $view = \View::make('employee.pdf-card-back-index',compact('data'));
                $html = $view->render();

                $pdf = new TCPDF('P', PDF_UNIT, array(54,86), true, 'UTF-8', false);

                $fontname = TCPDF_FONTS::addTTFfont('font/Exo-Bold.ttf', 'TrueTypeUnicode', '', 32);
                $pdf::SetFont($fontname, '', 14, '', false);


                $pdf::SetMargins(0, 0, 0,0);

                $pdf::SetAutoPageBreak(TRUE, 0);


                $pdf::AddPage('P');

                // for direct print

                $img_file = 'cardphoto/fronthead.png';
                $pdf::Image($img_file, 0, 0, 181, 26, '', '', '', false, 300, '', false, false, 0);



                $img_file = 'cardphoto/backhead.png';
                $pdf::Image($img_file, 5, 40, 170, 35, '', '', '', false, 300, '', false, false, 0);


//                $img_file = 'cardphoto/frontfoot.png';
//                $pdf::Image($img_file, 0, 260, 181, 30, '', '', '', false, 300, '', false, false, 0);

                $pdf::writeHTML($html, true, false, true, false, '');


                $pdf::Output('idcard.pdf');


                break;

        }

        return true;

    }


 public function recomended($id)
    {
        if(check_privilege(18,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $data = EmpPersonal::query()->where('company_id',1)->where('id',$id)
            ->with('title')->with('professional')->first();

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)->orderBy('name','ASC')->pluck('name','id');

        $emp_data = EmpPersonal::query()->where('id',$id)->first();

        return view('employee.employee-recomended',compact('emp_data','departments','designations','data'));
    }

    public function recomendedTableData($id)
    {
        $recomendeds = EmpRecomended::query()
                    ->where('company_id',1)
                    ->where('emp_personals_id',$id)
                    ->with('department')
                    ->with('designation')
                    ->get();

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)->pluck('name','id');
        $designations = Designation::query()->where('company_id',$this->company_id)
            ->where('status',true)->orderBy('name','ASC')->pluck('name','id');


        return DataTables::of($recomendeds)

            ->addColumn('action', function ($recomendeds) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-rowid="'. $recomendeds->id . '"
                        data-department="'. $recomendeds->department_d . '"
                        data-designation="'. $recomendeds->designation_id . '"
                        data-proposed_salary="'. $recomendeds->proposed_salary . '"
                        data-descriptions="'. $recomendeds->descriptions . '"
                        type="button" href="#modal-update-recomended" data-target="#modal-update-recomended" data-toggle="modal" class="btn btn-sm btn-recomended-edit btn-primary pull-left"><i class="fa fa-edit" >Edit</i></button>
                        
                        <button data-remote="delete/' . $recomendeds->id . '" type="button" class="btn btn-sm btn-recomended-delete btn-danger pull-right"><i class="fa fa-trash" >Delete</i></button>
                    </div>
                    ';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function saveRecomended(Request $request)
    {        

        $effective_date = $request->filled('effective_date') ? Carbon::createFromFormat('d-m-Y',$request['effective_date']) : null;

        DB::beginTransaction();

        try {

            $request['company_id'] = $this->company_id;            
            $request['emp_personals_id'] = $request['n_recomended_emp_id'];
            $request['employee_id'] = $request['employee_id'];
            $request['department_id'] = $request['department_id'];
            $request['designation_id'] = $request['designation_id'];
            $request['effective_date'] = $effective_date;
            $request['promotion_name'] = $request['promotion_name'];
            $request['change_designame'] = $request['change_designame'];
            $request['aditional_amt'] = $request['aditional_amt'];
            $request['fixation_amt'] = $request['fixation_amt'];
            $request['proposed_salary'] = $request['proposed_salary'];
            $request['promoted'] = $request['promoted'];
            $request['description'] = $request['description'];
            $request['user_id'] = $this->user_id;

            EmpRecomended::query()->create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return response()->json(['error' => $error], 404);
        }

        DB::commit();

        return response()->json(['success' => 'Added Employee Recomended Data'], 200);

    }
    public function leavePrint($id)
    {
        $leave = LeaveApplication::query()->where('id',$id)->first();


        $view = \View::make('leave.print.print-leave-approval-letter',compact('leave'));

        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage('P');

        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output('leave.pdf');

        return;

    }


}
