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


class LeaveDeptExport implements FromView, WithEvents
{

    use Exportable;
    protected $data;
    protected $employees;
    protected $departments;
    protected $from_date;
    protected $to_date;
    protected $status;


    public function __construct($data,$from_date,$to_date,$employees,$departments,$status)
    {
        $this->data = $data;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->employees = $employees;
        $this->departments = $departments;
        $this->status = $status;
    }

    public function view(): View
    {
        return view('leave.export.leave-dept-report-export', [
            'data' => $this->data,'from_date'=>$this->from_date,'to_date'=>$this->to_date,'employees' => $this->employees,'departments' => $this->departments,'status'=>$this->status
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {

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


                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A7:R7')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A7:R7')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(40);
//                $event->sheet->setAutoSize(true);
            },
        ];


    }
}
