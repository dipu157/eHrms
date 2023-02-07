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

class EmployeeDesigWiseExport implements FromView
{
	use Exportable;
    protected $employees;
    protected $designation;
    protected $designations;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($employees,$designation,$designations)
    {
        $this->employees = $employees;
        $this->designation = $designation;
        $this->designations = $designations;
    }

    public function view(): View
    {
//        dd($this->data);

        return view('employee.export.export-desigWiseEmployee-list', [
            'employees'=>$this->employees,'designation'=>$this->designation,'designations'=>$this->designations]);
    }


    public function collection()
    {
//        return EmpProfessional::query()->where('department_id',5)->get();
       // return EmpProfessional::all();
    }
}
