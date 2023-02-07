<?php

namespace App\Http\Controllers\Hospitality;

use App\Models\Common\OrgCalender;
use App\Models\Hospitality\FoodBeverage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApproveFoodChargeController extends Controller
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

        if(check_privilege(741,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $period = OrgCalender::query()->where('company_id',$this->company_id)
            ->where('food_open','O')->first();


        $data = FoodBeverage::query()->where('company_id',$this->company_id)
            ->where('c_year',$period->calender_year)->where('month_id',$period->month_id)
            ->where('status',true)
            ->with('professional')
            ->get();

        $charges = collect();
        $row=[];

        foreach ($data as $line)
        {
            $row['employee_id'] = $line->employee_id;
            $row['name'] = $line->professional->personal->full_name;
            $row['designation'] = $line->professional->designation->name;
            $row['precedence'] = $line->professional->designation->precedence;
            $row['department'] = $line->professional->department->name;
            $row['amount'] = $line->amount;
            $row['description'] = $line->description;
            $row['status'] = $line->status;

            $charges->push($row);
        }

        $charges = $charges->sortBy('precedence');

        return view('hospitality.approve-food-charge-index',compact('charges','period'));
    }

    public function approve()
    {

        if(check_privilege(741,2) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $period = OrgCalender::query()->where('company_id',$this->company_id)
            ->where('food_open','O')->first();

        DB::beginTransaction();

        try {

            $ids = FoodBeverage::query()->where('company_id',$this->company_id)
                ->where('c_year',$period->calender_year)
                ->where('month_id',$period->month_id)
                ->update(['approver_id'=>$this->user_id,'approved_at'=>Carbon::now(),
                'status'=>false]);


//            foreach ($ids as $id)
//            {
//
//            }

            //CLOSE THE MONTH

            OrgCalender::query()->where('company_id',$this->company_id)
                ->where('id',$period->id)->update(['food_open'=>'C']);

            //OPEN NEXT MONTH

            OrgCalender::query()->where('company_id',$this->company_id)
                ->where('id',$period->id + 1)->update(['food_open'=>'O']);


        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
//            $request->session()->flash('alert-danger', $error.'Not Saved');
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Hospitality\ApproveFoodChargeController@index')->with('Approved');


    }
}
