<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeOvertimeExport implements FromView
{
    use Exportable;
    protected $from_date;
    protected $to_date;
    protected $summary;

    protected $dept_data;
    protected $dates;
    protected $departments;
    protected $employees;


    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($summary,$from_date,$to_date,$dept_data,$dates,$employees,$departments)
    {
        $this->summary = $summary;
        $this->from_date = $from_date;
        $this->to_date = $to_date;

        $this->departments = $departments;
        $this->dates = $dates;
        $this->dept_data = $dept_data;
        $this->employees = $employees;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('overtime.export.employee-overtime-export', [
            'summary' => $this->summary,'from_date'=>$this->from_date,'to_date'=>$this->to_date,'departments'=>$this->departments,
            'dates'=>$this->dates,'dept_data'=>$this->dept_data ,'employees'=>$this->employees
        ]);
    }


    public function collection()
    {
        //
    }
}
