<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class BonusStatmentExport implements FromView
{
    use Exportable;
    protected $period;
    protected $bonus;
    protected $sections;    
    protected $departments;
    protected $dept_sum;


    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($period, $bonus, $sections, $departments, $dept_sum)
    {
        $this->period = $period;
        $this->bonus = $bonus;
        $this->sections = $sections;        
        $this->departments = $departments;
        $this->dept_sum = $dept_sum;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('payroll.export.pdf-bonus-export', [
            'period'=>$this->period,'bonus'=>$this->bonus,'sections'=>$this->sections,
            'departments'=>$this->departments,'dept_sum'=>$this->dept_sum]);
    }


    public function collection()
    {
        //
    }
}
