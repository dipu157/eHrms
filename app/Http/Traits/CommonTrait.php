<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/18/19
 * Time: 11:30 AM
 */

namespace App\Http\Traits;


use Illuminate\Support\Facades\Auth;

trait CommonTrait
{
    public function getCompanyId() {

        $company_id = Auth::user()->company_id;
        return $company_id;

    }

    public function getUserId() {

        $user_id = Auth::id();
        return $user_id;

    }

}