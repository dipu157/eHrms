<?php

namespace App\Http\Controllers\Report\Doctor;

use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReferDoctorServiceAdviceController extends Controller
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

//            dd($request['doctor_id']);


            $fromDate = Carbon::createFromFormat('d-m-Y H:i:s',$request['from_date'].' 00:00:01')->format('Y-m-d H:i:s');
            $toDate = Carbon::createFromFormat('d-m-Y H:i:s',$request['to_date'].' 23:59:59')->format('Y-m-d H:i:s');
            $doctor_id = $request['doctor_id'];


            $db_ext = DB::connection('sqlsrv');

            $doctor = $db_ext->table('refer_doctor_master')->where('ref_doctor_code',$doctor_id)->first();


            $services = $db_ext->table('item_of_service')->where('Status','A')
                ->select('Service_code','Service_Name','Sub_Dept_Code')
                ->get();


            $opddata = $db_ext->select("select bm.external_dr_code, p.Sub_Dept_Code,  bd.service_code, sum(bd.no_of_test) count_no, sum(bd.amount_payableby_patient) payable  
                        from opd_bill_detail bd
                        join OPD_Bill_Main bm on bm.Bill_ID = bd.Bill_ID
                        join item_of_service p on p.Service_code = bd.service_code
                        join department_sub sd on sd.sub_code = p.Sub_Dept_Code
                        where bd.encoded_date between '$fromDate' and '$toDate' and bd.status = 'A'
                        and bm.external_dr_code = '$doctor_id' --and p.Sub_Dept_Code not in(298,10,248,283,43,25,277)
                        group by bm.external_dr_code, p.Sub_Dept_Code, bd.service_code;");

            $data = collect($opddata);

//            $data = Collect();
//
//            foreach($services as $row)
//            {
//                foreach ($opd as $op)
//                {
//                    if($row->Service_code == $op->service_code)
//                    {
//                        $row->opd_count = $op->count_no;
//                        $row->ipd_count = 0;
//                        $data->push($row);
//                    }
//                }
//
//            }

//            foreach($services as $row)
//            {
//                foreach ($ipd as $ip)
//                {
//                    if($row->Service_code == $ip->service_code)
//                    {
//                        if($data->contains('Service_code',$row->Service_code))
//                        {
//                            foreach ($data as $rowdata){
//                                if($rowdata->Service_code == $row->Service_code)
//                                {
//                                    $rowdata->ipd_count = $rowdata->ipd_count + $ip->count_no;
//                                }
//                            }
//
//                        }else
//                        {
//                            $row->ipd_count = $ip->count_no;
//                            $row->opd_count = 0;
//                            $data->push($row);
//                        }
//                    }
//                }
//            }

//            $num = $data->groupBy('Sub_Dept_Code')->map(function ($row)  {
//
//                return $row->sum('opd_count');
//
//            });

            $num = $data->groupBy('Sub_Dept_Code')->map(function ($row)  {

                $grouped = Collect();

                $row->opdg = $row->sum('opd_count');
                $row->payable = $row->sum('payable');

                $grouped->push($row);

                return $grouped;

            });


            $subdpt = $db_ext->table('department_sub')->where('Status','A')->get();

            $view = \View::make('report.doctor.pdf.refer-doctor-advice-print', compact('num','data','doctor','fromDate','toDate','subdpt'));
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

            $pdf::SetMargins(20, 5, 5,0);

            $pdf::AddPage();

            $pdf::writeHTML($html, true, false, true, false, '');
            $pdf::Output('invest.pdf');

        }

        return view('report.doctor.refer-doctor-service-advice-index');
    }
}
