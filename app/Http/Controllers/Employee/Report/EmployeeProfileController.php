<?php

namespace App\Http\Controllers\Employee\Report;

use App\Models\Employee\EmpPersonal;
use App\Models\Employee\EmpProfessional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeProfileController extends Controller
{
    public function index(Request $request)
    {
        $data = null;

        if(!empty($request['personal_id']))
        {
            $data = EmpPersonal::query()->where('id',$request['personal_id'])
                ->with('professional','leave','leaveApp')
                ->first();

            dd($data);
        }

        return view('employee.report.employee-profile-index',compact('data'));
    }
}
