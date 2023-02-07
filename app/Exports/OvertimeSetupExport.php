<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class OvertimeSetupExport implements FromView
{
    use Exportable;
    protected $from_date;
    protected $to_date;
    protected $department_id;

    protected $dept_data;
    protected $dates;
    protected $departments;


    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;

    public function __construct($data,$from_date,$to_date,$dept_data,$dates,$departments)
    {
        $this->data = $data;
        $this->from_date = $from_date;
        $this->to_date = $to_date;

        $this->departments = $departments;
        $this->dates = $dates;
        $this->dept_data = $dept_data;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('overtime.export.overtime-setup-export', [
            'data' => $this->data,'from_date'=>$this->from_date,'to_date'=>$this->to_date,'departments'=>$this->departments,
            'dates'=>$this->dates,'dept_data'=>$this->dept_data
        ]);
    }


    public function collection()
    {
        //
    }
}
