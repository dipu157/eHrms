<?php

namespace App\Http\Controllers\Auth;

use App\Models\Common\Privilege;
use App\Models\Common\UseCase;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrivillegeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->company_id = Auth::user()->company_id;
            $this->user_id = Auth::user()->id;

            return $next($request);
        });
    }

    public function index(Request $request)
    {

        if(check_privilege(3,1) == false) //2=Add User  1=view
        {
//            session()->flash('danger', 'You do not have permission');
            return redirect()->back()->with('error', 'You do not have permission. Please contact your administrator');
            die();
        }


//        if(Auth::user()->id == 1)
//        {
            $emails = User::query()->where('status',true)
                ->orderBy('email','ASC')
                ->pluck('email','id');
            $menus = UseCase::query()->where('menu_type','M')->pluck('name','menu_id');
//        }else{
//
//            $emails = User::query()->where('attached',Auth::user()->attached)
//                ->pluck('email','id');
//        }


        $privilleges = null;

        if(!empty($request['user_email']))
        {

            $usecases = UseCase::query()->where('status', true)
                ->whereNotExists(function($query) use ($request)
                {
                    $query->select(DB::raw(1))
                        ->from('privileges')
                        ->whereRaw('use_cases.id = privileges.menu_id')
                        ->where('user_id',$request['user_email']);
                })->get();


            foreach ($usecases as $row)
            {
                Privilege::query()->insert([
                    'company_id' => $this->company_id,
                    'user_id' => $request['user_email'],
                    'menu_id' => $row->id,
                    'group_id'=>$row->menu_id,
                    'approver_id'=> $this->user_id
                ]);
            }

            $data = Privilege::query()->where('user_id',$request['user_email'])
                ->where('group_id',$request['group_id'])->with('usecase')
                ->get();

            $user = User::query()->where('id',$request['user_email'])->first();

//            dd(decrypt($user->b_pass));


        }

        return view('auth.privillege-index',compact('emails','data','user','menus'));
    }

    public function grant(Request $request)
    {


//        if(check_privilege(3,2) == false) //2=Add User  1=view
//        {
////            session()->flash('danger', 'You do not have permission');
//            return redirect()->back()->with('error', 'You do not have permission. Please contact your administrator');
//            die();
//        }

//        dd($request);


        DB::beginTransaction();

        try {

            Privilege::query()->where('user_id', $request['action'])
                ->where('company_id',$this->company_id)
                ->where('group_id',$request['group_id'])
                ->update(['view' => false,'add' => false, 'edit' => false, 'delete' =>false]);


            if(!empty($request['view']))
            {
                foreach ($request['view'] as $view)
                {
                    Privilege::query()->where('user_id',$request['action'])->where('menu_id',$view)
                        ->where('company_id',$this->company_id)
                        ->update(['view'=>true]);
                }
            }


            if(!empty($request['add']))
            {
                foreach ($request['add'] as $view)
                {
                    Privilege::query()->where('user_id',$request['action'])->where('menu_id',$view)
                        ->where('company_id',$this->company_id)
                        ->update(['add'=>true]);
                }
            }


            if(!empty($request['edit']))
            {
                foreach ($request['edit'] as $view)
                {
                    Privilege::query()->where('user_id',$request['action'])->where('menu_id',$view)
                        ->where('company_id',$this->company_id)
                        ->update(['edit'=>true]);
                }
            }


            if(!empty($request['delete']))
            {
                foreach ($request['delete'] as $view)
                {
                    Privilege::query()->where('user_id',$request['action'])->where('menu_id',$view)
                        ->where('company_id',$this->company_id)
                        ->update(['delete'=>true]);
                }
            }

        }catch (\Exception $e)
        {
            DB::rollBack();
            $error = $e->getMessage();
            return redirect()->back()->with('error','Not Saved '.$error);
        }

        DB::commit();

        return redirect()->action('Auth\PrivillegeController@index')->with('success','Successfully Granted');

    }
}
