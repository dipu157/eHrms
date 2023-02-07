<?php

use Illuminate\Database\Seeder;
use App\Models\Common\Division;

class DivisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Division::create( [
            'id'=>1,
            'company_id'=>1,
            'division_code'=>NULL,
            'name'=>'General Administration Division',
            'short_name'=>'GAD',
            'description'=>NULL,
            'started_from'=>'2019-01-17',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'27096@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>'CEO/CFO/GM',
            'user_id'=>1,
            'created_at'=>'2019-01-17 07:57:54',
            'updated_at'=>'2019-01-17 07:57:54'
        ] );



        Division::create( [
            'id'=>2,
            'company_id'=>1,
            'division_code'=>NULL,
            'name'=>'Medical Services Division',
            'short_name'=>'MSD',
            'description'=>NULL,
            'started_from'=>'2019-01-17',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'31372@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>'DDMS',
            'user_id'=>1,
            'created_at'=>'2019-01-17 07:58:40',
            'updated_at'=>'2019-01-17 07:58:40'
        ] );




    }
}
