<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class CashSalaryExport implements FromView
{
    use Exportable;
    protected $period;
    protected $salaries;


    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($period,$salaries)
    {
        $this->period = $period;
        $this->salaries = $salaries;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('payroll.export.cash-salary-export', [
            'period'=>$this->period,'salaries'=>$this->salaries]);
    }


    public function collection()
    {
        //
    }
}
