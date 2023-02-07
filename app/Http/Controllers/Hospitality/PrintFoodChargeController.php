<?php

namespace App\Http\Controllers\Hospitality;

use App\Models\Common\OrgCalender;
use App\Models\Hospitality\FoodBeverage;
use Elibyy\TCPDF\Facades\TCPDF;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PrintFoodChargeController extends Controller
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

    public function index(Request $request)
    {
        if(check_privilege(743,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $charges = null;

        if($request->filled('search_year'))
        {
            $year = $request['search_year'];
            $month = get_month_from_number($request['search_month']);

            $data = FoodBeverage::query()->where('company_id',$this->company_id)
                ->where('c_year',$request['search_year'])->where('month_id',$request['search_month'])
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

            $departments = $charges->unique('department');

            switch ($request['action'])
            {
                case 'preview':
                    return view('hospitality.print-food-charge-index',compact('charges','year','month','departments'));
                    break;

                case 'print':

                    $view = \View::make('hospitality.pdf-food-charges',compact('charges','year','month'));
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

                    $pdf::SetMargins(10, 5, 5,0);

                    $pdf::AddPage();

                    $pdf::writeHTML($html, true, false, true, false, '');
                    $pdf::Output('foodcharge.pdf');

                    break;


            }

        }

        return view('hospitality.print-food-charge-index',compact('charges'));
    }
}
