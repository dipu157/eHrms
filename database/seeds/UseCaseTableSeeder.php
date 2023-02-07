<?php

use Illuminate\Database\Seeder;
use App\Models\Common\UseCase;

class UseCaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Usecase::create( [
            'id'=>1,
            'company_id'=>1,
            'menu_type'=>'M',
            'menu_id'=>'A',
            'usecase_id'=>'A00',
            'name'=>'AUTH',
            'status'=>1,
            'created_at'=>'2019-01-15 04:02:24',
            'updated_at'=>'2019-01-15 04:02:24'
        ] );



        Usecase::create( [
            'id'=>2,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'A',
            'usecase_id'=>'A01',
            'name'=>'Add User',
            'status'=>1,
            'created_at'=>'2019-01-15 04:06:36',
            'updated_at'=>'2019-01-15 04:06:36'
        ] );



        Usecase::create( [
            'id'=>3,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'A',
            'usecase_id'=>'A02',
            'name'=>'User Privillege',
            'status'=>1,
            'created_at'=>'2019-01-15 04:10:30',
            'updated_at'=>'2019-01-15 04:10:30'
        ] );



        Usecase::create( [
            'id'=>4,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'A',
            'usecase_id'=>'A03',
            'name'=>'Change Password',
            'status'=>1,
            'created_at'=>'2019-01-15 04:10:30',
            'updated_at'=>'2019-01-15 04:10:30'
        ] );



        Usecase::create( [
            'id'=>5,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'A',
            'usecase_id'=>'A04',
            'name'=>'Reset Password',
            'status'=>1,
            'created_at'=>'2019-01-15 04:10:30',
            'updated_at'=>'2019-01-15 04:10:30'
        ] );



        Usecase::create( [
            'id'=>6,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'A',
            'usecase_id'=>'A05',
            'name'=>'Report',
            'status'=>1,
            'created_at'=>'2019-01-15 04:10:30',
            'updated_at'=>'2019-01-15 04:10:30'
        ] );



        Usecase::create( [
            'id'=>7,
            'company_id'=>1,
            'menu_type'=>'M',
            'menu_id'=>'B',
            'usecase_id'=>'B00',
            'name'=>'COMPANY',
            'status'=>1,
            'created_at'=>'2019-01-15 04:11:08',
            'updated_at'=>'2019-01-15 04:11:08'
        ] );



        Usecase::create( [
            'id'=>8,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'B',
            'usecase_id'=>'B01',
            'name'=>'Company Info',
            'status'=>1,
            'created_at'=>'2019-01-15 04:12:04',
            'updated_at'=>'2019-01-15 04:12:04'
        ] );



        Usecase::create( [
            'id'=>9,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'B',
            'usecase_id'=>'B02',
            'name'=>'Company Report',
            'status'=>1,
            'created_at'=>'2019-01-15 04:12:04',
            'updated_at'=>'2019-01-15 04:12:04'
        ] );



        Usecase::create( [
            'id'=>10,
            'company_id'=>1,
            'menu_type'=>'M',
            'menu_id'=>'C',
            'usecase_id'=>'C00',
            'name'=>'ADMIN',
            'status'=>1,
            'created_at'=>'2019-01-15 04:12:41',
            'updated_at'=>'2019-01-15 04:12:41'
        ] );



        Usecase::create( [
            'id'=>11,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'C',
            'usecase_id'=>'C01',
            'name'=>'Divisions',
            'status'=>1,
            'created_at'=>'2019-01-15 04:14:19',
            'updated_at'=>'2019-01-15 04:14:19'
        ] );



        Usecase::create( [
            'id'=>12,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'C',
            'usecase_id'=>'C02',
            'name'=>'Departments',
            'status'=>1,
            'created_at'=>'2019-01-15 04:14:19',
            'updated_at'=>'2019-01-15 04:14:19'
        ] );



        Usecase::create( [
            'id'=>13,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'C',
            'usecase_id'=>'C03',
            'name'=>'Sections',
            'status'=>1,
            'created_at'=>'2019-01-15 04:14:19',
            'updated_at'=>'2019-01-15 04:14:19'
        ] );



        Usecase::create( [
            'id'=>14,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'C',
            'usecase_id'=>'C04',
            'name'=>'Admin Report',
            'status'=>1,
            'created_at'=>'2019-01-15 04:14:19',
            'updated_at'=>'2019-01-15 04:14:19'
        ] );



        Usecase::create( [
            'id'=>15,
            'company_id'=>1,
            'menu_type'=>'M',
            'menu_id'=>'D',
            'usecase_id'=>'D00',
            'name'=>'EMPLOYEE',
            'status'=>1,
            'created_at'=>'2019-01-15 04:15:14',
            'updated_at'=>'2019-01-15 04:15:14'
        ] );



        Usecase::create( [
            'id'=>16,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'D',
            'usecase_id'=>'D01',
            'name'=>'Designations',
            'status'=>1,
            'created_at'=>'2019-01-15 04:17:04',
            'updated_at'=>'2019-01-15 04:17:04'
        ] );



        Usecase::create( [
            'id'=>17,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'D',
            'usecase_id'=>'D02',
            'name'=>'Titles',
            'status'=>1,
            'created_at'=>'2019-01-15 04:17:04',
            'updated_at'=>'2019-01-15 04:17:04'
        ] );



        Usecase::create( [
            'id'=>18,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'D',
            'usecase_id'=>'D03',
            'name'=>'Employee',
            'status'=>1,
            'created_at'=>'2019-01-15 04:17:04',
            'updated_at'=>'2019-01-15 04:17:04'
        ] );



        Usecase::create( [
            'id'=>19,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'D',
            'usecase_id'=>'D04',
            'name'=>'Employee Reports',
            'status'=>1,
            'created_at'=>'2019-01-15 04:17:04',
            'updated_at'=>'2019-01-15 04:17:04'
        ] );



        Usecase::create( [
            'id'=>20,
            'company_id'=>1,
            'menu_type'=>'M',
            'menu_id'=>'E',
            'usecase_id'=>'E00',
            'name'=>'ROSTER',
            'status'=>1,
            'created_at'=>'2019-01-17 06:02:56',
            'updated_at'=>'2019-01-17 06:02:56'
        ] );



        Usecase::create( [
            'id'=>21,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'E',
            'usecase_id'=>'E01',
            'name'=>'Duty Locations',
            'status'=>1,
            'created_at'=>'2019-01-17 06:03:19',
            'updated_at'=>'2019-01-21 11:41:23'
        ] );



        Usecase::create( [
            'id'=>22,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'E',
            'usecase_id'=>'E02',
            'name'=>'Roster Shift Settings',
            'status'=>1,
            'created_at'=>'2019-01-21 11:42:10',
            'updated_at'=>'2019-01-24 03:11:41'
        ] );



        Usecase::create( [
            'id'=>23,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'E',
            'usecase_id'=>'E03',
            'name'=>'Roster Entry',
            'status'=>1,
            'created_at'=>'2019-01-24 03:12:31',
            'updated_at'=>'2019-01-24 03:12:31'
        ] );



        Usecase::create( [
            'id'=>24,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'E',
            'usecase_id'=>'E04',
            'name'=>'Roster Update',
            'status'=>1,
            'created_at'=>'2019-01-24 03:13:29',
            'updated_at'=>'2019-01-24 03:13:29'
        ] );



        Usecase::create( [
            'id'=>25,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'E',
            'usecase_id'=>'E05',
            'name'=>'Roster Approve',
            'status'=>1,
            'created_at'=>'2019-01-24 03:13:29',
            'updated_at'=>'2019-01-24 03:13:29'
        ] );



        Usecase::create( [
            'id'=>26,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'E',
            'usecase_id'=>'E06',
            'name'=>'Roster View',
            'status'=>1,
            'created_at'=>'2019-01-24 03:13:29',
            'updated_at'=>'2019-01-24 03:13:29'
        ] );



        Usecase::create( [
            'id'=>27,
            'company_id'=>1,
            'menu_type'=>'M',
            'menu_id'=>'F',
            'usecase_id'=>'F00',
            'name'=>'LEAVE',
            'status'=>1,
            'created_at'=>'2019-01-27 10:55:22',
            'updated_at'=>'2019-01-27 10:55:22'
        ] );



        Usecase::create( [
            'id'=>28,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'F',
            'usecase_id'=>'F01',
            'name'=>'Leave Master',
            'status'=>1,
            'created_at'=>'2019-01-27 10:55:53',
            'updated_at'=>'2019-01-27 10:55:53'
        ] );



        Usecase::create( [
            'id'=>29,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'F',
            'usecase_id'=>'F02',
            'name'=>'Leave Application',
            'status'=>1,
            'created_at'=>'2019-01-27 10:57:04',
            'updated_at'=>'2019-01-27 10:57:04'
        ] );



        Usecase::create( [
            'id'=>30,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'F',
            'usecase_id'=>'F03',
            'name'=>'Leave Recommendation',
            'status'=>1,
            'created_at'=>'2019-01-27 10:57:04',
            'updated_at'=>'2019-01-27 10:57:04'
        ] );



        Usecase::create( [
            'id'=>31,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'F',
            'usecase_id'=>'F04',
            'name'=>'Leave Approval',
            'status'=>1,
            'created_at'=>'2019-01-27 10:57:04',
            'updated_at'=>'2019-01-27 10:57:04'
        ] );



        Usecase::create( [
            'id'=>32,
            'company_id'=>1,
            'menu_type'=>'S',
            'menu_id'=>'F',
            'usecase_id'=>'F05',
            'name'=>'Leave Reports',
            'status'=>1,
            'created_at'=>'2019-01-27 10:57:04',
            'updated_at'=>'2019-01-27 10:57:04'
        ] );




    }
}
