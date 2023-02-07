<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Common\Division;
use App\Models\Common\Department;
use App\Models\Common\Section;
use App\Models\Common\Location;
use App\Models\Common\WorkingStatus;
use App\Models\Employee\Designation;
use App\Models\Leaves\LeaveMaster;
use App\Models\Roster\Shift;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Elibyy\TCPDF\Facades\TCPDF;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        if(check_privilege(11,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        return view('admin.report.AllReport-index');
    }

    public function divisionList($status)
    {
        $div_list = Division::query()->where('company_id',1)->where('status',1)->get();

        //dd($div_list);

        switch ($status)
        {

            case 'divList':

                $div_list = Division::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.divisionList-print', compact('div_list'));

                break;

            case 'deptList':

                $dept_list = Department::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.departmentList-print', compact('dept_list'));
                
                break;

            case 'secList':

                $sec_list = Section::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.sectionList-print', compact('sec_list'));
                
                break;

            case 'divdeptList':

                $dept_list = Department::query()
                ->where('company_id',1)
                ->where('status',1)
                ->orderBy('division_id','asc')
                ->get();

                $view = \View::make('admin.report.divwisedeptList-print', compact('dept_list'));
                
                break;

            case 'deptsecList':

                $sec_list = Section::query()->where('company_id',1)->where('status',1)->orderBy('department_id','asc')->get();

                $view = \View::make('admin.report.deptwisesectionList-print', compact('sec_list'));
                
                break;

            case 'divDeptSecList':

                $sec_list = Section::query()->where('company_id',1)->where('status',1)->orderBy('department_id','asc')->get();

                $view = \View::make('admin.report.divdeptsectionList-print', compact('sec_list'));
                
                break;

            case 'desigList':

                $designations = Designation::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.designationList-print', compact('designations'));
                
                break;

            case 'locationList':

                $locationLists = Location::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.locationList-print', compact('locationLists'));
                
                break;

            case 'shiftList':

                $shift_list = Shift::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.shiftList-print', compact('shift_list'));
                
                break;

            case 'leaveList':

                $leave_list = LeaveMaster::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.leaveList-print', compact('leave_list'));
                
                break;

            case 'workingStatusList':

                $workstatus_list = WorkingStatus::query()->where('company_id',1)->where('status',1)->get();

                $view = \View::make('admin.report.workstatusList-print', compact('workstatus_list'));
                
                break;
               

            default:

                dd($status);

        }

        
        $html = $view->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf::SetMargins(20, 5, 5,0);

        $pdf::AddPage();

        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output('Divisions.pdf');

    }
}
