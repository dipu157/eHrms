<?php

namespace App\Http\Controllers\Phone;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Phone\Phone;
use App\Models\Common\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\Roster\DutyLocation;

class PhoneController extends Controller
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

        $phoneNumbers = Phone::query()->where('company_id',$this->company_id)->where('status',true)->get();

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');

        $locations = DutyLocation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('location','ASC')->pluck('location','id');

        return view('phone.PhoneIndex',compact('departments','phoneNumbers','locations'));
    }

    public function phoneData()
    {
        $phoneNumbers = Phone::query()->where('company_id',1)->with('department')->with('location')->get();

        $departments = Department::query()->where('company_id', $this->company_id)->where('status', true)->pluck('name', 'id');

        $locations = DutyLocation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('location','ASC')->pluck('location','id');

        return DataTables::of($phoneNumbers,$departments,$locations)

            ->addColumn('action', function ($phoneNumbers) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="view/'.$phoneNumbers->id.'"  type="button" class="btn btn-view btn-sm btn-secondary"><i class="fa fa-open">View</i></button>

                    <button data-remote="edit/' . $phoneNumbers->id . 
                    '"data-rowid="'. $phoneNumbers->id . 
                    '"data-used_by="'. $phoneNumbers->used_by . 
                    '"data-department_id="'. $phoneNumbers->department_id .
                    '" data-location_id = "'. $phoneNumbers->location_id . 
                    '"data-phone_no = "'. $phoneNumbers->phone_no . 
                    '"data-ip_address = "'. $phoneNumbers->ip_address . 
                    '" type="button" href="#phone-update-modal" data-target="#phone-update-modal" data-toggle="modal" class="btn btn-sm btn-phone-edit btn-primary pull-center">
                    <i class="fa fa-edit" >Edit</i></button>
                    </div>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(Request $request)
    {
if(check_privilege(751,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
        $request['company_id'] = $this->company_id;
        $request['user_id'] = $this->user_id;

        DB::beginTransaction();

        try {

            Phone::create($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Phone\PhoneController@index');
    }

    public function update(Request $request)
    {
if(check_privilege(751,3) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
        // $departments = Department::query()->where('company_id', $this->company_id)->where('status', true)->pluck('name', 'id');

        //dd($request->all());

        DB::beginTransaction();

        try {

            Phone::find($request['id'])->update($request->all());


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Phone\PhoneController@index')->with('success',trans('message.success'));
    }

    public function reportIndex()
    {

        $phoneNumbers = Phone::query()->where('company_id',$this->company_id)->where('status',true)->get();

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');

        $locations = DutyLocation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('location','ASC')->pluck('location','id');

        return view('phone.report.PhoneReportIndex',compact('departments','phoneNumbers','locations'));
    }

    public function departmentreport(Request $request)
    {
        $departments = Department::query()->where('company_id', $this->company_id)
                ->where('status', true)
                ->orderBy('name')->pluck('name','id');

        $locations = DutyLocation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('location','ASC')->pluck('location','id');

        if ($request->filled('search_id')) {

            $departments = Department::query()->where('company_id', $this->company_id)
                ->where('status', true)
                ->orderBy('name')->get();

            if ($request->filled('department_id')) {

                $dept_name = Department::query()->where('company_id', $this->company_id)
                    ->where('status', true)->where('id', $request['department_id'])
                    ->pluck('name');

                 //dd($dept_name);

                $data = Phone::query()->where('company_id', $this->company_id)
                    ->where('department_id', $request['department_id'])
                    ->where('status',true)
                    ->with('location')
                    ->orderBy('department_id', 'ASC')
                    ->get();

                  //  dd($data);

            } else {

                    $data = Phone::query()->where('company_id', $this->company_id)
                    ->where('status',true)
                    ->with('department')
                    ->with('location')
                    ->orderBy('department_id', 'ASC')
                    ->get();
    
                     $dept_name = null;
            }

            libxml_use_internal_errors(true);

            switch ($request['action']) {

                case 'export':

                   return Excel::download(new PhoneExport($data, $departments), 'alldepartment_wise_phone.xlsx');
                    break;

                case    'print':

                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);


                    $view = \View::make('phone.report.print.pdf-phone-list', compact('data', 'departments', 'dept_name'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    $pdf::SetMargins(20, 5, 5, 0);
                    $pdf::AddPage();
                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('employeeList.pdf');

                    break;
            }
        }


        return view('phone.report.PhoneReportIndex', compact('departments', 'locations'));
        

    }

    public function locationreport(Request $request)
    {

        $departments = Department::query()->where('company_id', $this->company_id)
            ->where('status', true)
            ->orderBy('name')->pluck('name','id');

        $locations = DutyLocation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('location','ASC')->pluck('location','id');

        if ($request->filled('search_id')) {

            $locations = DutyLocation::query()->where('company_id', $this->company_id)
                ->where('status', true)
                ->orderBy('location')->get();

            if ($request->filled('location_id')) {

                $loc_name = DutyLocation::query()->where('company_id', $this->company_id)
                    ->where('status', true)->where('id', $request['location_id'])
                    ->pluck('location');

                 //dd($dept_name);

                $data = Phone::query()->where('company_id', $this->company_id)
                    ->where('location_id', $request['location_id'])
                    ->where('status',true)
                    ->with('department')
                    ->orderBy('location_id', 'ASC')
                    ->get();

                  //  dd($data);

            } else {

                    $data = Phone::query()->where('company_id', $this->company_id)
                    ->where('status',true)
                    ->with('department')
                    ->with('location')
                    ->orderBy('location_id', 'ASC')
                    ->get();
    
                     $loc_name = null;
            }

            libxml_use_internal_errors(true);

            switch ($request['action']) {

                case 'export':

                   return Excel::download(new EmployeeExport($data, $locations), 'alllocation_wise_phone.xlsx');
                    break;

                case    'print':

                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);


                    $view = \View::make('phone.report.print.pdf-location_wise_phone_list', compact('data', 'locations', 'loc_name'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
                    $pdf::SetMargins(20, 5, 5, 0);
                    $pdf::AddPage();
                    $pdf::writeHTML($html, true, false, true, false, '');


                    $pdf::Output('alllocation_wise_phone.pdf');

                    break;
            }
        }


        return view('phone.report.PhoneReportIndex', compact('departments', 'locations'));
    }

}
