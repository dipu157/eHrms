<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class SalaryStatementExport implements FromView
{
    use Exportable;
    protected $period;
    protected $salaries;
    protected $sections;
    protected $departments;
    protected $dept_sum;
    protected $divisions;
    protected $div_sum;


    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($period,$salaries,$sections,$departments,$dept_sum,$divisions,$div_sum)
    {
        $this->period = $period;
        $this->salaries = $salaries;
        $this->sections = $sections;
        $this->departments = $departments;
        $this->dept_sum = $dept_sum;
        $this->divisions = $divisions;
        $this->div_sum = $div_sum;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('payroll.export.salary-statment-export', [
            'period'=>$this->period,'salaries'=>$this->salaries,'sections'=>$this->sections,'departments'=>$this->departments,'dept_sum'=>$this->dept_sum,'divisions'=>$this->divisions,'div_sum'=>$this->div_sum]);
    }


    public function collection()
    {
        //
    }
}
