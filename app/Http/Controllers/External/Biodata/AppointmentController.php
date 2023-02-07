<?php

namespace App\Http\Controllers\External\Biodata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\External\Biodata\AppointmentLetter;
use App\Models\Common\Department;
use App\Models\Employee\Designation;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class AppointmentController extends Controller
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

        $data = AppointmentLetter::query()->orderBy('id', 'desc')->take(5)->get();

        //dd($data);

        $departments = Department::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');

        $designations = Designation::query()->where('company_id',$this->company_id)->where('status',true)
            ->orderBy('name','ASC')->pluck('name','id');

        return view('external.biodata.appointmentLetter-index',compact('data','departments','designations'));
    }

    public function create(Request $request)
    {

        DB::beginTransaction();

        try {

            $request['company_id'] = $this->company_id;
            $request['user_id'] = $this->user_id;
            $request['submission_date'] =  Carbon::createFromFormat('d-m-Y',$request['submission_date'])->format('Y-m-d');
            $request['joining_date'] =  Carbon::createFromFormat('d-m-Y',$request['joining_date'])->format('Y-m-d');
            $s_year =  Carbon::now()->format('Y');

            $max_no = AppointmentLetter::query()->where('company_id',$this->company_id)
                ->max('issue_number');
            $issue_no = $max_no > 0 ? $max_no + 1 : $s_year.'0001';

            $request['issue_number'] = $issue_no;

            $id = AppointmentLetter::query()->create($request->all());

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//          $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error',$error);
//            return response()->json(['error' => $error], 404);
        }

        DB::commit();


        return redirect()->action('External\Biodata\AppointmentController@index')->with('success','Appointment Letter Successfully Saved. ID :'.$id->issue_number);

        // return view('external.biodata.appointmentLetter-index',compact('data','departments','designations'));

    }

    public function printEngAppointLetter($id)
    {
        $data = AppointmentLetter::query()->where('company_id',$this->company_id)
            ->where('id',$id)
            ->get();

        //dd($data);

        $view = \View::make('external.biodata.print.pdf-english-appointment-letter', compact('data'));
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('AppointmentLetter.pdf');

    }

    public function printBangAppointLetter($id)
    {
        $data = AppointmentLetter::query()->where('company_id',$this->company_id)
            ->where('id',$id)
            ->first();

        return view('external.biodata.bangla-appointment-letter',compact('data'));

        //dd($data);

        // $view = \View::make('external.biodata.print.pdf-bangla-appointment-letter', compact('data'));
        // $html = $view->render();

        // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        // $pdf::SetMargins(20, 5, 5,0);

        // $pdf::AddPage();

        // $pdf::writeHTML($html, true, false, true, false, '');
        // $pdf::Output('AppointmentLetter.pdf');

    }
}
