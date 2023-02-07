<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeSecWiseExport implements FromView
{
	use Exportable;
    protected $employees;
    protected $designations;
    protected $sectionss;
    protected $dept_name;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($employees,$sectionss,$dept_name)
    {
        $this->employees = $employees;
        $this->sectionss = $sectionss;
        $this->dept_name = $dept_name;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('employee.export.export-sectionWiseEmployee-list', [
            'employees'=>$this->employees,'sectionss'=>$this->sectionss,'dept_name'=>$this->dept_name]);
    }


    public function collection()
    {

    }
}
