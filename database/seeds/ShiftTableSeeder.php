<?php

use Illuminate\Database\Seeder;
use App\Models\Roster\Shift;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Shift::create( [
            'id'=>1,
            'company_id'=>1,
            'name'=>'OFF',
            'short_name'=>'OFF',
            'from_time'=>'00:00:00',
            'to_time'=>'00:00:00',
            'duty_hour'=>0,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-01',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:31:21',
            'updated_at'=>'2019-01-27 11:31:43'
        ] );



        Shift::create( [
            'id'=>2,
            'company_id'=>1,
            'name'=>'GENERAL',
            'short_name'=>'G',
            'from_time'=>'09:00:00',
            'to_time'=>'18:00:00',
            'duty_hour'=>9,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-01',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:29:02',
            'updated_at'=>'2019-01-27 11:31:46'
        ] );



        Shift::create( [
            'id'=>3,
            'company_id'=>1,
            'name'=>'MORNING',
            'short_name'=>'M',
            'from_time'=>'08:00:00',
            'to_time'=>'15:00:00',
            'duty_hour'=>7,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-01',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:29:53',
            'updated_at'=>'2019-01-27 11:31:48'
        ] );



        Shift::create( [
            'id'=>4,
            'company_id'=>1,
            'name'=>'EVENING',
            'short_name'=>'E',
            'from_time'=>'15:00:00',
            'to_time'=>'22:00:00',
            'duty_hour'=>7,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-01',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:33:12',
            'updated_at'=>'2019-01-27 11:33:12'
        ] );



        Shift::create( [
            'id'=>5,
            'company_id'=>1,
            'name'=>'NIGHT',
            'short_name'=>'N',
            'from_time'=>'22:00:00',
            'to_time'=>'08:00:00',
            'duty_hour'=>10,
            'end_next_day'=>1,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:34:12',
            'updated_at'=>'2019-01-27 11:34:12'
        ] );



        Shift::create( [
            'id'=>6,
            'company_id'=>1,
            'name'=>'MORNING 1',
            'short_name'=>'M1',
            'from_time'=>'08:00:00',
            'to_time'=>'16:00:00',
            'duty_hour'=>8,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:35:07',
            'updated_at'=>'2019-01-27 11:35:07'
        ] );



        Shift::create( [
            'id'=>7,
            'company_id'=>1,
            'name'=>'MORNING H',
            'short_name'=>'MH',
            'from_time'=>'07:00:00',
            'to_time'=>'15:00:00',
            'duty_hour'=>8,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:36:30',
            'updated_at'=>'2019-01-27 11:36:30'
        ] );



        Shift::create( [
            'id'=>8,
            'company_id'=>1,
            'name'=>'EVENING H',
            'short_name'=>'EH',
            'from_time'=>'14:00:00',
            'to_time'=>'22:00:00',
            'duty_hour'=>8,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:37:15',
            'updated_at'=>'2019-01-27 11:37:15'
        ] );



        Shift::create( [
            'id'=>9,
            'company_id'=>1,
            'name'=>'NIGHT H',
            'short_name'=>'NH',
            'from_time'=>'22:00:00',
            'to_time'=>'07:00:00',
            'duty_hour'=>9,
            'end_next_day'=>1,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:37:55',
            'updated_at'=>'2019-01-27 11:37:55'
        ] );



        Shift::create( [
            'id'=>10,
            'company_id'=>1,
            'name'=>'MORNING I',
            'short_name'=>'MI',
            'from_time'=>'08:00:00',
            'to_time'=>'20:00:00',
            'duty_hour'=>12,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:44:42',
            'updated_at'=>'2019-01-27 11:44:42'
        ] );



        Shift::create( [
            'id'=>11,
            'company_id'=>1,
            'name'=>'NIGHT I',
            'short_name'=>'NI',
            'from_time'=>'20:00:00',
            'to_time'=>'08:00:00',
            'duty_hour'=>12,
            'end_next_day'=>1,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:46:38',
            'updated_at'=>'2019-01-27 11:46:38'
        ] );



        Shift::create( [
            'id'=>12,
            'company_id'=>1,
            'name'=>'EVENING 1',
            'short_name'=>'E1',
            'from_time'=>'15:00:00',
            'to_time'=>'23:00:00',
            'duty_hour'=>8,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:47:47',
            'updated_at'=>'2019-01-27 11:47:47'
        ] );



        Shift::create( [
            'id'=>13,
            'company_id'=>1,
            'name'=>'MORNING N',
            'short_name'=>'MN',
            'from_time'=>'08:00:00',
            'to_time'=>'14:00:00',
            'duty_hour'=>6,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:49:31',
            'updated_at'=>'2019-01-27 11:49:31'
        ] );



        Shift::create( [
            'id'=>14,
            'company_id'=>1,
            'name'=>'EVENING 2',
            'short_name'=>'EN',
            'from_time'=>'14:00:00',
            'to_time'=>'20:00:00',
            'duty_hour'=>6,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:51:18',
            'updated_at'=>'2019-01-27 11:51:18'
        ] );



        Shift::create( [
            'id'=>15,
            'company_id'=>1,
            'name'=>'EVENING DOCTOR',
            'short_name'=>'ED',
            'from_time'=>'13:00:00',
            'to_time'=>'21:00:00',
            'duty_hour'=>8,
            'end_next_day'=>0,
            'effective_date'=>'2019-01-27',
            'description'=>NULL,
            'terminal'=>'192.168.20.134',
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-27 11:51:53',
            'updated_at'=>'2019-01-27 11:51:53'
        ] );

    }
}
