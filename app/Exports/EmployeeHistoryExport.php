<?php

namespace App\Exports;

use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeHistoryExport implements FromView
{
	use Exportable;
    protected $employees1;
    protected $empHistory;
    protected $empRecomend;
    protected $designations;
    protected $departments;
    protected $dept_name;
    protected $enddate;

    public function __construct($employees1,$empHistory,$empRecomend,$designations,$departments,$dept_name,$enddate)
    {
        $this->employees1 = $employees1;
        $this->empHistory = $empHistory;
        $this->empRecomend = $empRecomend;
        $this->departments = $departments;
        $this->designations = $designations;
        $this->dept_name = $dept_name;
        $this->enddate = $enddate;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('employee.export.export-employeeHistory-list', [
            'employees1'=>$this->employees1,'empHistory'=>$this->empHistory,'empRecomend'=>$this->empRecomend,'designations'=>$this->designations,
            'departments'=>$this->departments,'dept_name'=>$this->dept_name,'enddate'=>$this->enddate,]);
    }
}
