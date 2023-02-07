<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class BonustoBankExport implements FromView
{
    use Exportable;
    protected $period;
    protected $bank;
    protected $bonus;


    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($period,$bank,$bonus)
    {
        $this->period = $period;
        $this->bank = $bank;
        $this->bonus = $bonus;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('payroll.export.bonus-bank-export', [
            'period'=>$this->period,'bank'=>$this->bank,'bonus'=>$this->bonus]);
    }


    public function collection()
    {
        //
    }
}
