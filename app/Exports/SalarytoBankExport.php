<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class SalarytoBankExport implements FromView
{
    use Exportable;
    protected $period;
    protected $bank;
    protected $salaries;


    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($period,$bank,$salaries)
    {
        $this->period = $period;
        $this->bank = $bank;
        $this->salaries = $salaries;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('payroll.export.payroll-bank-export', [
            'period'=>$this->period,'bank'=>$this->bank,'salaries'=>$this->salaries]);
    }


    public function collection()
    {
        //
    }
}
