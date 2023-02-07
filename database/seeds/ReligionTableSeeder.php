<?php

use Illuminate\Database\Seeder;
use App\Models\Common\Religion;

class ReligionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Religion::create( [
            'id'=>1,
            'name'=>'Islam',
            'status'=>0,
            'user_id'=>1,
            'created_at'=>'2019-01-15 05:54:51',
            'updated_at'=>'2019-01-15 05:54:51'
        ] );



        Religion::create( [
            'id'=>2,
            'name'=>'Hindu',
            'status'=>0,
            'user_id'=>1,
            'created_at'=>'2019-01-15 05:55:38',
            'updated_at'=>'2019-01-15 05:55:55'
        ] );



        Religion::create( [
            'id'=>3,
            'name'=>'Christian',
            'status'=>0,
            'user_id'=>1,
            'created_at'=>'2019-01-15 05:56:37',
            'updated_at'=>'2019-01-15 05:56:37'
        ] );



        Religion::create( [
            'id'=>4,
            'name'=>'Buddhist',
            'status'=>0,
            'user_id'=>1,
            'created_at'=>'2019-01-15 05:57:08',
            'updated_at'=>'2019-01-15 05:57:08'
        ] );



        Religion::create( [
            'id'=>5,
            'name'=>'Others',
            'status'=>0,
            'user_id'=>1,
            'created_at'=>'2019-01-15 05:57:17',
            'updated_at'=>'2019-01-15 05:57:17'
        ] );

    }
}
