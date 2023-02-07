<?php

namespace App\Exports;

use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use App\Models\Employee\EmpHistory;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeDeptWiseExport implements FromView
{
	use Exportable;
    protected $employees;    
    protected $designations;
    protected $departments;
    protected $dept_name;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($employees,$designations,$departments,$dept_name)
    {
        $this->employees = $employees;        
        $this->designations = $designations;
        $this->departments = $departments;
        $this->dept_name = $dept_name;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('employee.export.export-deptwise-empHistory', [
            'employees'=>$this->employees,'designations'=>$this->designations,'departments'=>$this->departments,'dept_name'=>$this->dept_name]);
    }


    public function collection()
    {
//        return EmpProfessional::query()->where('department_id',5)->get();
       // return EmpProfessional::all();
    }
}
