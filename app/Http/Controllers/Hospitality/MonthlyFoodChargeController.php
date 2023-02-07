<?php

namespace App\Http\Controllers\Hospitality;

use App\Models\Common\OrgCalender;
use App\Models\Employee\EmpProfessional;
use App\Models\Hospitality\FoodBeverage;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MonthlyFoodChargeController extends Controller
{
    public $company_id;
    public $user_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->company_id = Auth::user()->company_id;
            $this->user_id = Auth::id();

            return $next($request);
        });
    }

    public function index()
    {
        if(check_privilege(740,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

//        $divisions = Division::query()->where('company_id',1)->pluck('name','id');
        $period = OrgCalender::query()->where('food_open','O')->first();
//        $year = $period->calender_year;
//        $month = $period->id;
//
//
//
//        $employees = EmpProfessional::query()->where('company_id',$this->company_id)
//            ->whereIn('working_status_id',[1,2])->where('department_id',5)
//            ->with(['food'=>function($query) use($year, $month){
//                $query->where('c_year',$year)->where('month_id',$month)
//                    ->where('status',true);
//            }])
//            ->with('personal')->with('designation')
//            ->get();
//
//        dd($employees);



        return view('hospitality.monthly-food-charge-index',compact('period'));
    }

    public function foodChargeData()
    {

        $period = OrgCalender::query()->where('food_open','O')->first();

        $year = $period->calender_year;
        $month = $period->month_id;



        $employees = EmpProfessional::query()->where('company_id',$this->company_id)
            ->whereIn('working_status_id',[1,2,8])
            ->with(['food'=>function($query) use($year, $month){
                $query->where('c_year',$year)->where('month_id',$month)
                ->where('status',true);
            }])
            ->with('personal')->with('designation')
            ->get();


        return DataTables::of($employees)

            ->addColumn('action', function ($employees) {

                $amount = isset($employees->food->amount) ?  $employees->food->amount : 0;
                $description = isset($employees->food->description) ?  $employees->food->description : '';

                return '<div class="btn-group btn-group-sm" role="group" aria-label="Action Button">
                    <button data-remote="' . $employees->id . '" data-employee="'. $employees->employee_id . '"
                        data-amount="'. $amount . '" 
                        data-description="'. $description . '" 
                        type="button" href="#food-charge-modal" data-target="#food-charge-modal" data-toggle="modal" class="btn btn-sm btn-charge-edit btn-primary pull-center"><i class="fa fa-edit" >Edit</i></button>
                    </div>
                    ';
            })
            ->addColumn('amount', function($employees){
                return isset($employees->food->amount) ? $employees->food->amount : 0;
            })
            ->editColumn('image', function ($employees) {
                if (!isset($employees->personal->photo)) {
                    return '<img src="' . asset("assets/images/male.jpeg") .
                        '" alt=" " style="height: 30px; width: 50px;" >';
                }
                return '<img src="' . asset($employees->personal->photo) .
                    '" alt=" " style="height: 30px; width: 50px;" >';
            })
            ->rawColumns(['action','image','amount'])
            ->make(true);
    }

    public function create(Request $request)
    {

        if(check_privilege(740,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        DB::beginTransaction();

        try {

            FoodBeverage::query()->updateOrCreate(['employee_id'=>$request['employee_id'],'c_year'=>$request['year_id'],
                'month_id'=>$request['month_id']],
            ['amount'=>$request['amount'],'description'=>$request['description'],
            'user_id'=>$this->user_id, 'company_id'=>$this->company_id
            ]);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Hospitality\MonthlyFoodChargeController@index');
    }
}
