<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('users')->insert([
            'company_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@brbhospital.com',
            'role_id'=>1,
            'password' => bcrypt('pass123'),
            'pass_exp_date'=>'2020-11-24'
        ]);

//        DB::table('users')->insert([
//            'company_id' => 1,
//            'name' => 'HRAdmin',
//            'email' => 'hradmin@brbhospital.com',
//            'role_id'=>1,
//            'password' => bcrypt('hrm321'),
//            'pass_exp_date'=>'2020-11-24'
//        ]);
    }
}
