<?php

namespace App\Exports;

use App\Models\Attendance\DailyAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class AttendanceSummaryExport implements FromView, WithEvents
{

    use Exportable;
    protected $from_date;
    protected $to_date;
    protected $department_id;
//    public $company_id;
//
//    public function __construct($from_date,$to_date,$department_id)
//    {
//
//
//        $this->from_date = $from_date;
//        $this->department_id = $department_id;
//        $this->to_date = $to_date;
//    }
//
//    /**
//    * @return \Illuminate\Support\Collection
//    */
//    public function collection()
//    {
//        $data = DailyAttendance::query()
//            ->where('company_id',1)
//            ->where('department_id',$this->department_id)
//            ->whereBetween('attend_date',[$this->from_date,$this->to_date])
//            ->select('rownum, department_id','employee_id',
//                DB::raw('sum(case when attend_status = "P" and offday_flag = false and holiday_flag = false and leave_flag=false then 1 else 0 end) as present'),
//                DB::raw('sum(case when offday_flag = true and leave_flag=false and holiday_flag=false then 1 else 0 end) as offday'),
//
//                DB::raw('sum(case when leave_id = 1 then 1 else 0 end) as casual'),
//                DB::raw('sum(case when leave_id = 4 then 1 else 0 end) as earn'),
//                DB::raw('sum(case when leave_id = 2 then 1 else 0 end) as sick'),
//                DB::raw('sum(case when leave_id = 3 then 1 else 0 end) as alterLeave'),
//                DB::raw('sum(case when leave_id = 9 then 1 else 0 end) as wpLeave'),
//
//                DB::raw('floor(sum(case when late_flag = true then 1 else 0 end)/3) as lateCount'),
//
//                DB::raw('sum(case when holiday_flag = true then 1 else 0 end) as holiday'),
//                DB::raw('sum(case when (late_flag = true) and (late_allow = false) then 1 else 0 end) as late_count'),
//                DB::raw('sum(overtime_hour) as overtime_hour'),
//
//
//                DB::raw('sum(case when attend_status = "A" and leave_flag = false and  holiday_flag = false and offday_flag = false then 1 else 0 end) as absent')
//            )
//            ->groupBy('department_id','employee_id')
//            ->orderBy('employee_id','ASC')
//            ->with('department')
//            ->get();
//
//        $final = Collect();
//
//        foreach ($data as $row)
//        {
//            $row['total_lwp'] = $row->lateCount + $row->wpLeave;
//            $row['total_pdays'] = ($row->present + $row->offday + $row->holiday + $row->casual+ $row->earn + $row->sick + $row->alterLeave) - ($row->lateCount + $row->wpLeave);
//
//            $final->push($row);
//        }
//
//        return $final;
//    }
//
//    public function headings(): array
//    {
//        return [
//            'SL',
//            'ID',
//            'Name',
//            'Email',
//            'Created at',
//            'Updated at'
//        ];
//    }
//
//    public function view(): View
//    {
//        return view('attendance.exports.attendance-summary-export', [
//            'data' => [
//                [
//                    'name' => 'Povilas',
//                    'surname' => 'Korop',
//                    'email' => 'povilas@laraveldaily.com',
//                    'twitter' => '@povilaskorop'
//                ],
//                [
//                    'name' => 'Taylor',
//                    'surname' => 'Otwell',
//                    'email' => 'taylor@laravel.com',
//                    'twitter' => '@taylorotwell'
//                ]
//            ]
//        ]);
//    }

    private $final;

    public function __construct($final,$from_date,$to_date)
    {
        $this->final = $final;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function view(): View
    {
        return view('attendance.exports.attendance-summary-export', [
            'final' => $this->final,'from_date'=>$this->from_date,'to_date'=>$this->to_date
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {


//        $worksheet->getStyle('B2:G8')->applyFromArray($styleArray);


        return [
            AfterSheet::class    => function(AfterSheet $event) {

                $cellRange = 'A7:R7'; // All headers

                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ];


//                $event->sheet->getDelegate()->getProperties()
//                    ->setCreator("Maarten Balliauw")
//                    ->setLastModifiedBy("Maarten Balliauw")
//                    ->setTitle("Office 2007 XLSX Test Document")
//                    ->setSubject("Office 2007 XLSX Test Document")
//                    ->setDescription(
//                        "Test document for Office 2007 XLSX, generated using PHP classes."
//                    )
//                    ->setKeywords("office 2007 openxml php")
//                    ->setCategory("Test result file");


                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A7:R7')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A7:R7')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(40);
//                $event->sheet->setAutoSize(true);
            },
        ];


    }
}
