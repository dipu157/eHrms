<?php

use Illuminate\Database\Seeder;
use App\Models\Common\WorkingStatus;

class WorkingStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Workingstatus::create( [
            'id'=>1,
            'company_id'=>1,
            'name'=>'Regular',
            'short_name'=>'A',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-15 09:28:08',
            'updated_at'=>'2019-01-15 09:28:08'
        ] );



        Workingstatus::create( [
            'id'=>2,
            'company_id'=>1,
            'name'=>'Probationary',
            'short_name'=>'A',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-15 11:58:46',
            'updated_at'=>'2019-01-15 11:58:46'
        ] );



        Workingstatus::create( [
            'id'=>3,
            'company_id'=>1,
            'name'=>'Suspended',
            'short_name'=>'A',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-15 11:59:00',
            'updated_at'=>'2019-01-15 11:59:00'
        ] );



        Workingstatus::create( [
            'id'=>4,
            'company_id'=>1,
            'name'=>'Resigned',
            'short_name'=>'A',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-15 11:59:14',
            'updated_at'=>'2019-01-15 11:59:14'
        ] );



        Workingstatus::create( [
            'id'=>5,
            'company_id'=>1,
            'name'=>'Terminated',
            'short_name'=>'A',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-15 11:59:27',
            'updated_at'=>'2019-01-15 11:59:27'
        ] );



        Workingstatus::create( [
            'id'=>6,
            'company_id'=>1,
            'name'=>'Retired',
            'short_name'=>'A',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-15 11:59:38',
            'updated_at'=>'2019-01-15 11:59:38'
        ] );




    }
}
