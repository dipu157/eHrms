<?php

namespace App\Http\Controllers\Report\Doctor;

use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DoctorServiceReportController extends Controller
{
    public function index(Request $request)
    {

        if(check_privilege(501,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        if(!empty($request['doctor_id']))
        {
//            dd($request['doctor_id']);


            $fromDate = Carbon::createFromFormat('d-m-Y H:i:s',$request['from_date'].' 00:00:01')->format('Y-m-d H:i:s');
            $toDate = Carbon::createFromFormat('d-m-Y H:i:s',$request['to_date'].' 23:59:59')->format('Y-m-d H:i:s');
            $doctor_id = $request['doctor_id'];


            $db_ext = DB::connection('sqlsrv');

            $doctor = $db_ext->table('doctor_main')->where('Doctor_code',$doctor_id)->first();
            $specialisation = $db_ext->table('specialisation_master')->where('specialisation_code',$doctor->specialisation)->first();

            $ipddata =  $db_ext->select("select s.consultant_code, p.Sub_Dept_Code, s.service_code, count(s.No_of_Test) count_no
                        from investigation_sample s
                        inner join item_of_service p on p.Service_code = s.service_code
                        join department_sub sd on sd.sub_code = p.Sub_Dept_Code
                        where s.consultant_code = '$doctor_id' and s.encoded_date between '$fromDate' and '$toDate' and s.status = 'A'
                        group by s.consultant_code, p.Sub_Dept_Code, s.service_code;");

            $ipd = collect($ipddata);


            $services = $db_ext->table('item_of_service')->where('Status','A')
                ->select('Service_code','Service_Name','Sub_Dept_Code')
                ->get();




            $opddata = $db_ext->select("select bm.consultant_code, p.Sub_Dept_Code,  bd.service_code, sum(bd.no_of_test) count_no, sum(bd.amount_payableby_patient) payable  
                        from opd_bill_detail bd
                        join OPD_Bill_Main bm on bm.Bill_ID = bd.Bill_ID
                        join item_of_service p on p.Service_code = bd.service_code
                        join department_sub sd on sd.sub_code = p.Sub_Dept_Code
                        where bd.status = 'A'
                        and bd.encoded_date between '$fromDate' and '$toDate'
                        and bm.consultant_code = '$doctor_id' and p.Sub_Dept_Code not in(298,10,248,283,43,25,277)
                        group by bm.consultant_code, p.Sub_Dept_Code, bd.service_code;");

//            and p.Sub_Dept_Code not in(298,10,248,283,43,25,277)

            $opd = collect($opddata);

            $data = Collect();

            foreach($services as $row)
            {
                foreach ($opd as $op)
                {
                    if($row->Service_code == $op->service_code)
                    {
                        $row->opd_count = $op->count_no;
                        $row->opd_amount = $op->payable;
                        $row->ipd_count = 0;
                        $data->push($row);
                    }
                }

            }

            foreach($services as $row)
            {
                foreach ($ipd as $ip)
                {
                    if($row->Service_code == $ip->service_code)
                    {
                        if($data->contains('Service_code',$row->Service_code))
                        {
                            foreach ($data as $rowdata){
                                if($rowdata->Service_code == $row->Service_code)
                                {
                                    $rowdata->ipd_count = $rowdata->ipd_count + $ip->count_no;
                                }
                            }

                        }else
                        {
                            $row->ipd_count = $ip->count_no;
                            $row->opd_count = 0;
                            $row->opd_amount = 0;
                            $data->push($row);
                        }
                    }
                }
            }

            $num = $data->groupBy('Sub_Dept_Code')->map(function ($row)  {

                $grouped = Collect();

                $row->ipdg = $row->sum('ipd_count');
                $row->opdg = $row->sum('opd_count');
                $row->opda = $row->sum('opd_amount');

                $grouped->push($row);

                return $grouped;

            });

            $subdpt = $db_ext->table('department_sub')->where('Status','A')->get();

            $view = \View::make('report.doctor.pdf.doctor-service-report-print', compact('num','data','specialisation','doctor','fromDate','toDate','subdpt'));
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

            $pdf::SetMargins(20, 5, 5,0);

            $pdf::AddPage();

            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output('invest.pdf');

        }

        return view('report.doctor.doctor-service-report-index');
    }
}
