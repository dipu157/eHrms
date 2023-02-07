<?php

namespace App\Http\Controllers\Roster;

use App\Models\Common\Department;
use App\Models\Common\Location;
use App\Models\Common\Section;
use App\Models\Employee\EmpProfessional;
use App\Models\Roster\DutyLocation;
use App\Models\Roster\Roster;
use App\Models\Roster\Shift;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class PrintRosterController extends Controller
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

        if(check_privilege(26,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $departments = Department::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');

        $locations = DutyLocation::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('location','id');

            $sections = Section::query()->where('company_id',$this->company_id)
            ->where('status',true)->pluck('name','id');
        $year = null;
        $month = null;
        $department_id = Session::get('session_user_dept_id');


        if(!empty($request['action']))
        {

            switch ($request['action'])
            {
                case 'preview':

                    $year = $request['search_year'];
                    $month = $request['search_month'];
                    $department_id = $request['department_id'];

                break;

                case 'print':

                    $year = $request['search_year'];
                    $month = $request['search_month'];
                    $department_id = $request['department_id'];

                    $month_days=cal_days_in_month(CAL_GREGORIAN,$month,$year);


                    $dept_data = Department::query()->where('company_id',$this->company_id)
                        ->where('id',$department_id)->first();
                        
                        if($request->filled('section_id'))
                        {
                            $sec_id = $request['section_id'];
    
//dd($sec_id);
$sectionses = Section::query()->where('company_id',$this->company_id)
->where('id',$sec_id)->first();
                            // $roster = EmpProfessional::query()->where('company_id',$this->company_id)
                            //     ->where('department_id',$department_id)
                            //     ->whereIn('working_status_id',[1,2,8]) // regular
                            //     ->with(['roster' =>function ($query) use($year, $month, $loc_id) {
                            //         $query->where('r_year', $year)->where('month_id',$month)->where('loc_05',$loc_id);
                            //     }])
                            //     ->with('personal')
                            //     ->get();
    
                            $roster = EmpProfessional::query()->select('rosters.*','emp_personals.full_name','designations.short_name',
                                  'designations.short_name','duty_locations.location')
                               
                                  ->join('rosters', 'emp_professionals.employee_id', '=', 'rosters.employee_id')
                                  ->join('emp_personals', 'emp_professionals.emp_personals_id', '=', 'emp_personals.id')
                                  ->join('designations', 'emp_professionals.designation_id', '=', 'designations.id')
                                  ->join('duty_locations', 'rosters.loc_05', '=', 'duty_locations.id')
                                  //->where('emp_professionals.department_id',$department_id)
                                  ->where('rosters.r_year', $year)->where('rosters.month_id',$month)->where('emp_professionals.section_id',$sec_id)
                                  ->whereIn('emp_professionals.working_status_id',[1,2,8])
                                 
                                    ->get();
    
//dd($roster);
    
                            $locount = EmpProfessional::query()->select('duty_locations.location',DB::Raw('count(rosters.loc_05) as emp_count'))
                                    
                                    ->join('rosters', 'emp_professionals.employee_id', '=', 'rosters.employee_id')
               
                                    ->join('duty_locations', 'rosters.loc_05', '=', 'duty_locations.id')
                                    ->where('rosters.department_id',$department_id)
                                    ->where('rosters.r_year', $year)->where('rosters.month_id',$month)->where('emp_professionals.section_id',$sec_id)
                                    ->whereIn('emp_professionals.working_status_id',[1,2,8])
                                   
                                    ->groupBy('duty_locations.location')
                                      ->get();
    
                        }

                     elseif($request->filled('location_id'))
                    {
                        $loc_id = $request['location_id'];

                        //dd($loc_id);

                        // $roster = EmpProfessional::query()->where('company_id',$this->company_id)
                        //     ->where('department_id',$department_id)
                        //     ->whereIn('working_status_id',[1,2,8]) // regular
                        //     ->with(['roster' =>function ($query) use($year, $month, $loc_id) {
                        //         $query->where('r_year', $year)->where('month_id',$month)->where('loc_05',$loc_id);
                        //     }])
                        //     ->with('personal')
                        //     ->get();

                        $roster = EmpProfessional::query()->select('rosters.*','emp_personals.full_name','designations.short_name',
                              'designations.short_name','duty_locations.location')
                              
                              ->join('rosters', 'emp_professionals.employee_id', '=', 'rosters.employee_id')
                              ->join('emp_personals', 'emp_professionals.emp_personals_id', '=', 'emp_personals.id')
                              ->join('designations', 'emp_professionals.designation_id', '=', 'designations.id')
                              ->join('duty_locations', 'rosters.loc_05', '=', 'duty_locations.id')
                              ->where('rosters.department_id',$department_id)
                              ->where('rosters.r_year', $year)->where('rosters.month_id',$month)->where('rosters.loc_05',$loc_id)
                              ->whereIn('emp_professionals.working_status_id',[1,2,8])
                             
                                ->get();

                        

                        $locount = EmpProfessional::query()->select('duty_locations.location',DB::Raw('count(rosters.loc_05) as emp_count'))
                                
                                ->join('rosters', 'emp_professionals.employee_id', '=', 'rosters.employee_id')
           
                                ->join('duty_locations', 'rosters.loc_05', '=', 'duty_locations.id')
                                ->where('rosters.department_id',$department_id)
                                ->where('rosters.r_year', $year)->where('rosters.month_id',$month)->where('rosters.loc_05',$loc_id)
                                ->whereIn('emp_professionals.working_status_id',[1,2,8])
                               
                                ->groupBy('duty_locations.location')
                                  ->get();

                    }
                    else{

                         /* $roster = EmpProfessional::query()->where('company_id',$this->company_id)
                            ->where('department_id',$department_id)
                            ->whereIn('working_status_id',[1,2,8]) // regular
                            ->with(['roster' =>function ($query) use($year, $month) {
                                $query->where('r_year', $year)->where('month_id',$month);
                            }])
                            
                            ->with('personal')
                              ->get(); */
 


                        $roster = EmpProfessional::query()->select('rosters.*','emp_personals.full_name','designations.short_name',
                              'designations.short_name','duty_locations.location')
                              
                              ->join('rosters', 'emp_professionals.employee_id', '=', 'rosters.employee_id')
                              ->join('emp_personals', 'emp_professionals.emp_personals_id', '=', 'emp_personals.id')
                              ->join('designations', 'emp_professionals.designation_id', '=', 'designations.id')
                              ->join('duty_locations', 'rosters.loc_05', '=', 'duty_locations.id')
                              ->where('rosters.department_id',$department_id)
                              ->where('rosters.r_year', $year)->where('rosters.month_id',$month)
                              ->whereIn('emp_professionals.working_status_id',[1,2,8])
                             
                             ->orderBy('rosters.loc_05', 'asc')
                                ->get();

                        

                        $locount = EmpProfessional::query()->select('duty_locations.location',DB::Raw('count(rosters.loc_05) as emp_count'))
                                
                                ->join('rosters', 'emp_professionals.employee_id', '=', 'rosters.employee_id')
           
                                ->join('duty_locations', 'rosters.loc_05', '=', 'duty_locations.id')
                                ->where('rosters.department_id',$department_id)
                                ->where('rosters.r_year', $year)->where('rosters.month_id',$month)
                                ->whereIn('emp_professionals.working_status_id',[1,2,8])
                               
                                ->groupBy('duty_locations.location')
                                  ->get();
  


//dd($locount); 

                    }


                    $view = \View::make('roster.report.pdf.print-roster-pdf',compact('roster','locount','year','month','department_id','dept_data','locations','sectionses','month_days'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LEGAL', true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    $pdf::SetMargins(5, 5, 5,0);
                    $pdf::AddPage('L');

                    // for direct print

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('roster.pdf');

                    break;
            }
        }

        return view('roster.report.print-roster-index',compact('departments','year','month','department_id','locations','sections'));

    }

    public function getRosterData($year,$month,$dept_id)
    {

        $roster = EmpProfessional::query()->where('company_id',$this->company_id)
            ->where('department_id',$dept_id)
            ->whereIn('working_status_id',[1,2,8]) // regular
            ->with(['roster' =>function ($query) use($year, $month) {
                $query->where('r_year', $year)->where('month_id',$month);
            }])
            ->with('personal')
            ->get();


        return DataTables::of($roster)

            ->addColumn('employee', function ($roster) {

                return $roster->personal->full_name. '<br/>'. $roster->employee_id ;

            })
            ->addColumn('day_01', function ($roster) {

                return get_shift_data($roster->roster->day_01) ?? '';

            })

            ->addColumn('day_02', function ($roster) {

                return get_shift_data($roster->roster->day_02) ?? '';

            })

            ->addColumn('day_03', function ($roster) {

                return get_shift_data($roster->roster->day_03) ?? '';

            })

            ->addColumn('day_04', function ($roster) {

                return get_shift_data($roster->roster->day_04) ?? '';

            })

            ->addColumn('day_05', function ($roster) {

                return get_shift_data($roster->roster->day_05) ?? '';

            })

            ->addColumn('day_06', function ($roster) {

                return get_shift_data($roster->roster->day_06) ?? '';

            })

            ->addColumn('day_07', function ($roster) {

                return get_shift_data($roster->roster->day_07) ?? '';

            })

            ->addColumn('day_08', function ($roster) {

                return get_shift_data($roster->roster->day_08) ?? '';

            })
            ->addColumn('day_09', function ($roster) {

                return get_shift_data($roster->roster->day_09) ?? '';

            })
            ->addColumn('day_10', function ($roster) {

                return get_shift_data($roster->roster->day_10) ?? '';

            })
            ->addColumn('day_11', function ($roster) {

                return get_shift_data($roster->roster->day_11) ?? '';

            })
            ->addColumn('day_12', function ($roster) {

                return get_shift_data($roster->roster->day_12) ?? '';

            })
            ->addColumn('day_13', function ($roster) {

                return get_shift_data($roster->roster->day_13) ?? '';

            })
            ->addColumn('day_14', function ($roster) {

                return get_shift_data($roster->roster->day_14) ?? '';

            })
            ->addColumn('day_15', function ($roster) {

                return get_shift_data($roster->roster->day_15) ?? '';

            })
            ->addColumn('day_16', function ($roster) {

                return get_shift_data($roster->roster->day_16) ?? '';

            })
            ->addColumn('day_17', function ($roster) {

                return get_shift_data($roster->roster->day_17) ?? '';

            })
            ->addColumn('day_18', function ($roster) {

                return get_shift_data($roster->roster->day_18) ?? '';

            })
            ->addColumn('day_19', function ($roster) {

                return get_shift_data($roster->roster->day_19) ?? '';

            })

            ->addColumn('day_20', function ($roster) {

                return get_shift_data($roster->roster->day_20) ?? '';

            })
            ->addColumn('day_21', function ($roster) {

                return get_shift_data($roster->roster->day_21) ?? '';

            })
            ->addColumn('day_22', function ($roster) {

                return get_shift_data($roster->roster->day_22) ?? '';

            })
            ->addColumn('day_23', function ($roster) {

                return get_shift_data($roster->roster->day_23) ?? '';

            })
            ->addColumn('day_24', function ($roster) {

                return get_shift_data($roster->roster->day_24) ?? '';

            })
            ->addColumn('day_25', function ($roster) {

                return get_shift_data($roster->roster->day_25) ?? '';

            })
            ->addColumn('day_26', function ($roster) {

                return get_shift_data($roster->roster->day_26) ?? '';

            })
            ->addColumn('day_27', function ($roster) {

                return get_shift_data($roster->roster->day_27) ?? '';

            })
            ->addColumn('day_28', function ($roster) {

                return get_shift_data($roster->roster->day_28) ?? '';

            })
            ->addColumn('day_29', function ($roster) {

                return get_shift_data($roster->roster->day_29) ?? '';

            })
            ->addColumn('day_30', function ($roster) {

                return get_shift_data($roster->roster->day_30) ?? '';

            })
            ->addColumn('day_31', function ($roster) {

                return get_shift_data($roster->roster->day_31) ?? '';

            })
            ->addColumn('location', function ($roster) {

                return $roster->roster->location->location ?? '';

            })
            ->editColumn('status', function ($roster) {

                return $roster->roster->status == 1 ? 'Approved' : 'Create';

            })


            ->rawColumns(['employee','day_01','day_02','day_03', 'day_04','day_05','day_06','day_07','day_08',
                'day_09','day_10','day_11','day_12','day_13','day_14','day_15','day_16','day_17','day_18','day_19',
                'day_20','day_21','day_22','day_23','day_24','day_25','day_26','day_27','day_28','day_29','day_30','day_31','location','status'])

            ->make(true);


    }

}
