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

class EmployeeExport implements FromView
{
	use Exportable;
    protected $employees;
    protected $departments;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($employees,$departments)
    {
        $this->employees = $employees;
        $this->departments = $departments;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('employee.export.export-employee-list', [
            'employees'=>$this->employees,'departments'=>$this->departments]);
    }


    public function collection()
    {
//        return EmpProfessional::query()->where('department_id',5)->get();
       // return EmpProfessional::all();
    }
}
