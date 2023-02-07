<?php

use Illuminate\Database\Seeder;
use App\Models\Leaves\LeaveMaster;

class LeaveMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       LeaveMaster::create( [
            'id'=>1,
            'company_id'=>1,
            'name'=>'CASUAL LEAVE',
            'short_code'=>'CL',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:16:31',
            'updated_at'=>'2019-01-26 08:16:42'
        ] );



        Leavemaster::create( [
            'id'=>2,
            'company_id'=>1,
            'name'=>'SICK LEAVE',
            'short_code'=>'SL',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:17:02',
            'updated_at'=>'2019-01-26 08:17:02'
        ] );



        Leavemaster::create( [
            'id'=>3,
            'company_id'=>1,
            'name'=>'ALTERNATIVE LEAVE',
            'short_code'=>'AL',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:17:19',
            'updated_at'=>'2019-01-26 08:17:19'
        ] );



        Leavemaster::create( [
            'id'=>4,
            'company_id'=>1,
            'name'=>'EARN LEAVE',
            'short_code'=>'EL',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:17:50',
            'updated_at'=>'2019-01-26 08:17:50'
        ] );



        Leavemaster::create( [
            'id'=>5,
            'company_id'=>1,
            'name'=>'MATERNITY LEAVE',
            'short_code'=>'ML',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:18:08',
            'updated_at'=>'2019-01-26 08:18:08'
        ] );



        Leavemaster::create( [
            'id'=>6,
            'company_id'=>1,
            'name'=>'PATERNITY LEAVE',
            'short_code'=>'PL',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:18:24',
            'updated_at'=>'2019-01-26 08:18:24'
        ] );



        Leavemaster::create( [
            'id'=>7,
            'company_id'=>1,
            'name'=>'TRAINING LEAVE',
            'short_code'=>'TL',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:18:41',
            'updated_at'=>'2019-01-26 08:18:41'
        ] );



        Leavemaster::create( [
            'id'=>8,
            'company_id'=>1,
            'name'=>'SPECIAL LEAVE',
            'short_code'=>'SPL',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:18:57',
            'updated_at'=>'2019-01-26 08:18:57'
        ] );



        Leavemaster::create( [
            'id'=>9,
            'company_id'=>1,
            'name'=>'LEAVE WITHOUT PAY',
            'short_code'=>'LWP',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:19:08',
            'updated_at'=>'2019-01-26 08:19:08'
        ] );



        Leavemaster::create( [
            'id'=>10,
            'company_id'=>1,
            'name'=>'UNAUTHORIZED ABSENT',
            'short_code'=>'UA',
            'leave_type'=>'Y',
            'leave_limit'=>'Y',
            'yearly_limit'=>0,
            'is_carry_forward'=>'N',
            'show_roster'=>'Y',
            'particulars'=>NULL,
            'status'=>1,
            'user_id'=>1,
            'created_at'=>'2019-01-26 08:20:11',
            'updated_at'=>'2019-01-26 08:20:11'
        ] );
    }
}
