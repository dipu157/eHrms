<?php

namespace App\Http\Controllers\Company;

use App\Models\Company\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    public function index()
    {
//        $data = Company::query()->where('group_id',1)->get();
        return view('company.company-index');
    }


    public function companyData()
    {
        $companies = Company::query()->where('group_id',1)->get();


        return DataTables::of($companies)

            ->addColumn('action', function ($companies) {

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="create/'.$companies->id.'"  type="button" class="btn btn-create btn-sm btn-primary"><i class="fa fa-edit">Edit</i></button>
                    <button data-remote="edit/' . $companies->id . '" data-rowid="'. $companies->id . '" 
                        data-name="'. $companies->name . '" 
                        data-phoneno="'. $companies->phone_no . '"
                        data-address="'. $companies->address . '"
                        type="button" href="#company-update-modal" data-target="#company-update-modal" data-toggle="modal" class="btn btn-sm btn-company-edit btn-danger pull-center"><i class="fa fa-trash" >Delete</i></button>
                    </div>
                    ';
            })

            ->addColumn('status', function ($companies) {

                return $companies->status == true ? 'Active' : 'Disabled';
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }


}
