<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function passCheck(Request $request)
    {
        if(check_privilege(5,1) == false) //2=show Division  1=view
        {
            return redirect()->back()->with('error', trans('message.permission'));
            die();
        }

        $emails = User::query()->where('company_id',Auth::user()->company_id)->where('status',true)->pluck('email','id');
        $user = null;

        if(!empty($request['user_id']))
        {
            $user = User::query()->where('id',$request['user_id'])->first();

//            dd(isset($data->b_pass) ? decrypt($data->b_pass) : 'Please Ask Him To Change Password');
        }

        return view('auth.passwords.check',compact('emails','user'));
    }

}
