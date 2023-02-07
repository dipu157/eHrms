<?php

namespace App\Http\Controllers\Payroll\Salary;

use App\Exports\SalarytoBankExport;
use App\Exports\BonustoBankExport;
use App\Exports\BonusStatmentExport;
use App\Exports\SalaryStatementExport;
use App\Exports\CashSalaryExport;
use App\Models\Common\Bank;
use App\Models\Common\OrgCalender;
use App\Models\Common\Section;
use App\Models\Employee\EmpProfessional;
use App\Models\Employee\EmpPersonal;
use App\Models\Payroll\MonthlySalary;
use App\Models\Common\Department;
use App\Models\Payroll\Heldup;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SalaryReportController extends Controller
{
    public function index(Request $request)
    {

        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $periods = OrgCalender::query()->where('company_id', 1)->pluck('month_name', 'id');

        if ($request->filled('action')) {
            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();

            $salaries = EmpProfessional::query()->where('emp_professionals.company_id', 1)
                //->where('emp_personals.religion_id',2)
                ->whereIn('working_status_id',[1,2,8])
                ->with(['salary' => function ($query) use ($period) {
                    $query->where('period_id', $period->id);
                }])

                ->whereHas('salary', function ($query) use ($period) {
                    $query->where('period_id', $period->id)->where('withheld', false)->where('paid_days','>','0');
                })
                ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                ->join('emp_personals', 'emp_personals.id', '=', 'emp_professionals.emp_personals_id')
                ->orderBy('designations.precedence')
                ->with('personal')
                ->get();


            $sections = $salaries->unique('section_id');

            $departments = $salaries->unique('department_id');

            $tds = $salaries->unique('tds_id');

            $divisions = $salaries->unique('division_id');

            $dept_sum = $salaries->groupBy('department_id')->map(function ($row) {

                $grouped = Collect();
                //                $row->department_id = $row->department_id;
               $row->dep_count = $row->count('salary.employee_id');
                $row->basic = $row->sum('salary.basic');
                $row->house_rent = $row->sum('salary.house_rent');
                $row->medical = $row->sum('salary.medical');
                $row->entertainment = $row->sum('salary.entertainment');

                $row->conveyance = $row->sum('salary.conveyance');
                $row->other_allowance = $row->sum('salary.other_allowance');
                $row->gross_salary = $row->sum('salary.gross_salary');
                $row->paid_days = $row->sum('salary.paid_days');
                $row->earned_salary = $row->sum('salary.earned_salary');
                $row->increment_amt = $row->sum('salary.increment_amt');
                $row->arear_amount = $row->sum('salary.arear_amount');
                $row->overtime_hour = $row->sum('salary.overtime_hour');
                $row->overtime_amount = $row->sum('salary.overtime_amount');
                $row->payable_salary = $row->sum('salary.payable_salary');

                $row->income_tax = $row->sum('salary.income_tax');
                $row->advance = $row->sum('salary.advance');
                $row->mobile_others = $row->sum('salary.mobile_others');
                $row->stamp_fee = $row->sum('salary.stamp_fee');
                $row->food_charge = $row->sum('salary.food_charge');
                $row->net_salary = $row->sum('salary.net_salary');

                $grouped->push($row);

                return $grouped;
            });

            $div_sum = $salaries->groupBy('division_id')->map(function ($row) {

                $groupeds = Collect();

                $row->basic = $row->sum('salary.basic');
                $row->house_rent = $row->sum('salary.house_rent');
                $row->medical = $row->sum('salary.medical');
                $row->entertainment = $row->sum('salary.entertainment');

                $row->conveyance = $row->sum('salary.conveyance');
                $row->other_allowance = $row->sum('salary.other_allowance');
                $row->gross_salary = $row->sum('salary.gross_salary');
                $row->paid_days = $row->sum('salary.paid_days');
                $row->earned_salary = $row->sum('salary.earned_salary');
                $row->increment_amt = $row->sum('salary.increment_amt');
                $row->arear_amount = $row->sum('salary.arear_amount');
                $row->overtime_hour = $row->sum('salary.overtime_hour');
                $row->overtime_amount = $row->sum('salary.overtime_amount');
                $row->payable_salary = $row->sum('salary.payable_salary');

                $row->income_tax = $row->sum('salary.income_tax');
                $row->advance = $row->sum('salary.advance');
                $row->mobile_others = $row->sum('salary.mobile_others');
                $row->stamp_fee = $row->sum('salary.stamp_fee');
                $row->food_charge = $row->sum('salary.food_charge');
                $row->net_salary = $row->sum('salary.net_salary');

                $groupeds->push($row);

                return $groupeds;
            });

            libxml_use_internal_errors(true);

            switch ($request['action']) {
                case 'preview':

                    $view = \View::make('payroll.salary.report.pdf.pdf-monthly-salary', compact('period', 'salaries', 'sections', 'departments', 'dept_sum', 'divisions', 'div_sum', 'tds'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::changeFormat(array(216, 420));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('salary.pdf');

                    break;

                case 'print':

                    $view = \View::make('payroll.salary.report.pdf.pdf-monthly-salary', compact('period', 'salaries', 'sections', 'departments', 'dept_sum', 'divisions', 'div_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::changeFormat(array(216, 420));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('salary.pdf');

                    break;

                case 'download':

                    return Excel::download(new SalaryStatementExport($period,$salaries, $sections, $departments, $dept_sum, $divisions, $div_sum), 'SalaryStatment.xlsx');
            }
        }

        return view('payroll.salary.report.salary&Bonus-report-index', compact('periods'));
    }

    public function BonusReport(Request $request)
    {
        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $periods = OrgCalender::query()->where('company_id', 1)->pluck('month_name', 'id');

        if ($request->filled('action')) {
            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();

            $bonus = EmpProfessional::query()->where('emp_professionals.company_id', 1)
                ->whereIn('working_status_id', [1, 2, 8])
                ->with(['bonus' => function ($query) use ($period) {
                    $query->where('period_id', $period->id);
                }])
                ->whereHas('bonus', function ($query) use ($period) {
                    $query->where('period_id', $period->id)->where('withheld', false)->where('net_bonus','>',0);
                })
                ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                ->orderBy('designations.precedence')
                ->with('personal')
                ->get();

            //            dd($bonus);

            $sections = $bonus->unique('section_id');

            $departments = $bonus->unique('department_id');

            $dept_sum = $bonus->groupBy('department_id')->map(function ($row) {

                $grouped = Collect();
                //                $row->department_id = $row->department_id;
                $row->basic = $row->sum('bonus.basic');
                $row->basic = $row->sum('bonus.bonus');
                $row->basic = $row->sum('bonus.stamp_fee');

                $grouped->push($row);

                return $grouped;
            });

            //            dd($dept_sum);
            //            dd($departments);

            libxml_use_internal_errors(true);

            switch ($request['action']) {

                case 'preview':

                    $view = \View::make('payroll.salary.report.pdf.pdf-bonus', compact('period', 'bonus', 'sections', 'departments', 'dept_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bonus.pdf');

                    break;


                case 'print':

                    $view = \View::make('payroll.salary.report.pdf.pdf-bonus', compact('period', 'bonus', 'sections', 'departments', 'dept_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bonus.pdf');

                    break;

                case 'download':

                    return Excel::download(new BonusStatmentExport($period, $bonus, $sections, $departments, $dept_sum), 'BonusStatment.xlsx');
                    break;
            }
        }

        return view('payroll.salary.report.salary&Bonus-report-index', compact('periods'));
    }

    public function bankLetterIndex(Request $request)
    {

        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $banks = Bank::query()->where('company_id', 1)->pluck('name', 'id');

        if (!empty($request['month_id'])) {
            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();

            $bank = Bank::query()->where('id', $request['bank_id'])->first();

            $salaries = EmpProfessional::query()->where('emp_professionals.company_id', 1)
                //->where('emp_personals.religion_id',2)
                ->whereIn('working_status_id', [1, 2, 8])
                ->with(['salary' => function ($query) use ($period, $bank) {
                    $query->where('period_id', $period->id)->where('bank_id', $bank->id)->where('withheld', false);
                }])
                ->whereHas('salary', function ($query) use ($period, $bank) {
                    $query->where('period_id', $period->id)->where('bank_id', $bank->id)->where('withheld', false)->where('paid_days','>',0)->where('net_salary', '>', 0)->where('account_no', '>', 0);
                })
                ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                ->join('emp_personals', 'emp_personals.id', '=', 'emp_professionals.emp_personals_id')
                ->orderBy('designations.precedence')
                ->with('personal')
                ->get();


            switch ($request['action']) {
                case 'preview':

                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-bank-letter', compact('period', 'salaries', 'bank'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            $pdf::changeFormat(array(216,420));
                    //            $pdf::reset();

                    $pdf::SetMargins(30, 45, 10, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bankLetter.pdf');

                    break;


                case 'print':

                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-bank-letter', compact('period', 'salaries', 'bank'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            $pdf::changeFormat(array(216,420));
                    //            $pdf::reset();

                    $pdf::SetMargins(30, 45, 10, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bankLetter.pdf');

                    break;

                case 'download':

                    return Excel::download(new SalarytoBankExport($period, $bank, $salaries), 'SalarytoBank.xlsx');

                    break;
            }
        }
        return view('payroll.salary.report.bank-letter-index', compact('banks'));
    }

    public function cashbonusIndex(Request $request)
    {
        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $periods = OrgCalender::query()->where('company_id', 1)->pluck('month_name', 'id');

        if ($request->filled('action')) {
            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();

            $bonus = EmpProfessional::query()->where('emp_professionals.company_id', 1)
                ->whereIn('working_status_id', [1, 2, 8])
                ->with(['bonus' => function ($query) use ($period) {
                    $query->where('period_id', $period->id);
                }])
                ->whereHas('bonus', function ($query) use ($period) {
                    $query->where('period_id', $period->id)->where('withheld', false)->where('net_bonus','>',0)->where('account_no', 0);
                })
                ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                ->orderBy('designations.precedence')
                ->with('personal')
                ->get();

            //            dd($bonus);

            $sections = $bonus->unique('section_id');

            $departments = $bonus->unique('department_id');

            $dept_sum = $bonus->groupBy('department_id')->map(function ($row) {

                $grouped = Collect();
                //                $row->department_id = $row->department_id;
                $row->basic = $row->sum('bonus.basic');
                $row->basic = $row->sum('bonus.bonus');
                $row->basic = $row->sum('bonus.stamp_fee');

                $grouped->push($row);

                return $grouped;
            });

            //            dd($dept_sum);
            //            dd($departments);

            libxml_use_internal_errors(true);

            switch ($request['action']) {

                case 'preview':

                    $view = \View::make('payroll.salary.report.pdf.pdf-cashbonus', compact('period', 'bonus', 'sections', 'departments', 'dept_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bonus.pdf');

                    break;


                case 'print':

                    $view = \View::make('payroll.salary.report.pdf.pdf-cashbonus', compact('period', 'bonus', 'sections', 'departments', 'dept_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::SetMargins(20, 5, 5, 0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bonus.pdf');

                    break;

                case 'download':

                    return Excel::download(new BonusStatmentExport($period, $bonus, $sections, $departments, $dept_sum), 'CashBonusStatment.xlsx');
                    break;
            }
        }

        return view('payroll.salary.report.cash-bonus-index', compact('periods'));
    }

    public function overtimeReportIndex(Request $request)
    {

        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }
        $dept_lists = Department::query()->where('status',true)
            ->orderBy('name')->pluck('name','id');
        if (!empty($request['month_id'])) {

            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();
               

            //dd($period);

            switch ($request['action']) {

                case 'print':
                   

                    if($request->filled('department_id'))
                    {
    
                       
        
                   
                    $salaries = EmpProfessional::query()->where('emp_professionals.company_id', 1)->where('emp_professionals.department_id',$request['department_id'])
             
                    ->with(['salary' => function ($query) use ($period) {
                        $query->where('period_id', $period->id);
                    }])
    
                    ->whereHas('salary', function ($query) use ($period) {
                        $query->where('period_id', $period->id)->where('withheld', false)->where('paid_days','>','0')->where('net_salary', '>', 0)->where('overtime_amount','>','0');
                    })
                    
                    ->orderBy('emp_professionals.employee_id')
                    ->with('personal')
                    ->get();
             
                    $departments = $salaries->unique('department_id');
    //dd($salaries);
    //dd($departments);
           $dept_sum = $salaries->groupBy('department_id')->map(function ($row) {
    
                    $grouped = Collect();
                                
                    $row->overtime_hour = $row->sum('salary.overtime_hour');
                    $row->overtime_amount = $row->sum('salary.overtime_amount');
                    
                    $grouped->push($row);
    
                    return $grouped;
                });
    
                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.Pdf-employeeWise-monthly-salary-Overtime-report', compact('period', 'salaries',  'departments', 'dept_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                  

                    $pdf::SetMargins(30, 30, 40, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('Overtime_employee.pdf');

                    break;
                }   

                else{

                    $salaries = EmpProfessional::query()->where('emp_professionals.company_id', 1)
             
                    ->with(['salary' => function ($query) use ($period) {
                        $query->where('period_id', $period->id);
                    }])
    
                    ->whereHas('salary', function ($query) use ($period) {
                        $query->where('period_id', $period->id)->where('withheld', false)->where('paid_days','>','0')->where('net_salary', '>', 0)->where('overtime_amount','>','0');
                    })
       
                    ->orderBy('emp_professionals.department_id')
                    ->with('personal')
                    ->get();
             
                    $departments = $salaries->unique('department_id');
    
    //dd($departments);
           
    $dept_sum = $salaries->groupBy('department_id')->map(function ($row) {
    
                    $grouped = Collect();
                                
                    $row->overtime_hour = $row->sum('salary.overtime_hour');
                    $row->overtime_amount = $row->sum('salary.overtime_amount');
                    
                    $grouped->push($row);
    
                    return $grouped;
                });
    
                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.Pdf-all-Dept-employeeWise-monthly-salary-Overtime-report', compact('period', 'salaries',  'departments', 'dept_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                  

                    $pdf::SetMargins(30, 30, 40, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('Overtime_employee.pdf');

                    break; 
                }
                case 'summary':
                    $salaries = EmpProfessional::query()->where('emp_professionals.company_id', 1)
             
                    ->with(['salary' => function ($query) use ($period) {
                        $query->where('period_id', $period->id);
                    }])
    
                    ->whereHas('salary', function ($query) use ($period) {
                        $query->where('period_id', $period->id)->where('withheld', false)->where('paid_days','>','0')->where('net_salary', '>', 0)->where('overtime_amount','>','0');
                    })
       
                    ->orderBy('emp_professionals.department_id')
                    ->with('personal')
                    ->get();
             
                    $departments = $salaries->unique('department_id');
    
    
           $dept_sum = $salaries->groupBy('department_id')->map(function ($row) {
    
                    $grouped = Collect();
                          $row->employee_count = $row->count('salary.employee_id');      
                    $row->overtime_hour = $row->sum('salary.overtime_hour');
                    $row->overtime_amount = $row->sum('salary.overtime_amount');
                    
                    $grouped->push($row);
    
                    return $grouped;
                });
    
                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-Overtime-salary-report', compact('period', 'salaries', 'departments', 'dept_sum'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            $pdf::changeFormat(array(216,420));
                    //            $pdf::reset();

                    $pdf::SetMargins(30, 45, 10, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('Deparment_monthly_overtime.pdf');

                    break;
            }
        }
       
        return view('payroll.salary.report.overtime-report-index', compact('dept_lists'));
    }

    public function bonusTobankIndex(Request $request)
    {

        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $banks = Bank::query()->where('company_id', 1)->pluck('name', 'id');

        if (!empty($request['month_id'])) {
            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();

            $bank = Bank::query()->where('id', $request['bank_id'])->first();

            $bonus = EmpProfessional::query()->where('emp_professionals.company_id', 1)
                ->whereIn('working_status_id', [1, 2, 8])
                ->with(['bonus' => function ($query) use ($period, $bank) {
                    $query->where('period_id', $period->id)->where('bank_id', $bank->id)->where('withheld', false)->where('account_no', '>', 0);
                }])
                ->whereHas('bonus', function ($query) use ($period, $bank) {
                    $query->where('period_id', $period->id)->where('bank_id', $bank->id)->where('withheld', false)->where('bonus', '>', 0)->where('account_no', '>', 0);
                })
                ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                ->orderBy('designations.precedence')
                ->with('personal')
                ->get();

            switch ($request['action']) {
                case 'preview':

                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-bonus-to-bank', compact('period', 'bonus', 'bank'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            $pdf::changeFormat(array(216,420));
                    //            $pdf::reset();

                    $pdf::SetMargins(30, 45, 10, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bankLetter.pdf');

                    break;


                case 'print':

                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-bonus-to-bank', compact('period', 'bonus', 'bank'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            $pdf::changeFormat(array(216,420));
                    //            $pdf::reset();

                    $pdf::SetMargins(30, 45, 10, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('bankLetter.pdf');

                    break;

                case 'download':

                    return Excel::download(new BonustoBankExport($period, $bank, $bonus), 'BonustoBank.xlsx');

                    break;
            }
        }
        return view('payroll.salary.report.bonus-to-bank', compact('banks'));
    }

    public function CashsalaryReport(Request $request)
    {

        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $banks = Bank::query()->where('company_id', 1)->pluck('name', 'id');

        if (!empty($request['month_id'])) {
            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();

            $salaries = EmpProfessional::query()->where('emp_professionals.company_id', 1)
                //->where('emp_personals.religion_id',2)
                ->whereIn('working_status_id', [1, 2, 8])
                ->with(['salary' => function ($query) use ($period) {
                    $query->where('period_id', $period->id)->where('withheld', false)->where('account_no', 0);
                }])
                ->whereHas('salary', function ($query) use ($period) {
                    $query->where('period_id', $period->id)->where('withheld', false)->where('account_no', 0)->where('net_salary', '>', 0);
                })
                ->join('designations', 'designations.id', '=', 'emp_professionals.designation_id')
                ->join('emp_personals', 'emp_personals.id', '=', 'emp_professionals.emp_personals_id')
                ->orderBy('designations.precedence')
                ->with('personal')
                ->get();

            $departments = $salaries->unique('department_id');

           // dd($departments);

            libxml_use_internal_errors(true);

            switch ($request['action']) {
                case 'preview':

                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-cash-salary-report', compact('period', 'salaries','departments'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    $pdf::SetMargins(30, 30, 40, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('cashsalary.pdf');

                    break;

                case 'print':

                $view = \View::make('payroll.salary.report.pdf.pdf-cash-salary-report', compact('period', 'salaries','departments'));
                
                $html = $view->render();

                $pdf = new TCPDF('L', PDF_UNIT, array(216, 420), true, 'UTF-8', false);

                    //            set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 10000000);

                    //            $pdf::SetMargins(10, 5, 5,0);

                    $pdf::changeFormat(array(216, 420));
                    $pdf::reset();

                    $pdf::AddPage('L');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });

                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('CashSalary.pdf');

                    break;


                case 'download':

                    return Excel::download(new CashSalaryExport($period, $salaries,$departments), 'CashSalary.xlsx');

                    break;
            }
        }
        return view('payroll.salary.report.cash-salary-index');
    }

    public function heldupIndex(Request $request)
    {

        if (check_privilege(703, 1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }


        if (!empty($request['month_id'])) {
            $period = OrgCalender::query()->where('calender_year', $request['year_id'])
                ->where('month_id', $request['month_id'])->first();

            $data = EmpProfessional::query()->where('company_id', 1)
                ->with(['salary' => function ($query) use ($period) {
                    $query->where('period_id', $period->id)->where('withheld', true);
                }])
                ->whereHas('salary', function ($query) use ($period) {
                    $query->where('period_id', $period->id)->where('withheld', true);
                })
                ->with('personal')
                ->get();


            switch ($request['action']) {
                case 'preview':

                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-heldup-salary-report', compact('period', 'data'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            $pdf::changeFormat(array(216,420));
                    //            $pdf::reset();

                    $pdf::SetMargins(30, 30, 40, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('heldupEmployee.pdf');

                    break;

                case 'print':

                    // set_time_limit(180);
                    ini_set('max_execution_time', 900);
                    ini_set('memory_limit', '1024M');
                    ini_set("output_buffering", 10240);
                    ini_set('max_input_time', 300);
                    ini_set('default_socket_timeout', 300);
                    ini_set('pdo_mysql.cache_size', 4000);
                    ini_set('pcre.backtrack_limit', 5000000);

                    $view = \View::make('payroll.salary.report.pdf.pdf-heldup-salary-report', compact('period', 'data'));
                    $html = $view->render();

                    $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

                    //            $pdf::changeFormat(array(216,420));
                    //            $pdf::reset();

                    $pdf::SetMargins(30, 45, 10, 20);

                    $pdf::AddPage('P');

                    $pdf::setFooterCallback(function ($pdf) {

                        // Position at 15 mm from bottom
                        $pdf->SetY(-10);
                        // Set font
                        $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
                        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                    });


                    $pdf::writeHTML($html, true, false, true, false, '');

                    $pdf::Output('heldupEmployee.pdf');

                    break;
            }
        }
        return view('payroll.salary.report.heldup-salary-index');
    }
}
