<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ShiftAllEmployeeAttendance implements FromView
{
    use Exportable;
    protected $data;
    protected $report_date;
    protected $shifts;
    protected $employees;
    protected $departments;


    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data,$report_date,$shifts,$employees,$departments)
    {
        
        $this->data = $data;
        $this->report_date = $report_date;
        $this->shifts = $shifts;
        $this->employees = $employees;
        $this->departments = $departments;
        
    }

    public function view(): View
    {
//        dd($this->data);

        return view('employee.export.shift-Allemployee-export', [
            'data'=>$this->data,'report_date'=>$this->report_date,'shifts'=>$this->shifts,'employees'=>$this->employees,'departments'=>$this->departments]);
    }


    public function collection()
    {
        //
    }
}
