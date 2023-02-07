<?php

use Illuminate\Database\Seeder;
use App\Models\Common\Section;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Section::create( [
            'id'=>1,
            'company_id'=>1,
            'department_id'=>14,
            'section_code'=>NULL,
            'name'=>'Call Center',
            'short_name'=>'CC',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'16472@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:31:52',
            'updated_at'=>'2019-01-27 05:31:52'
        ] );



        Section::create( [
            'id'=>2,
            'company_id'=>1,
            'department_id'=>14,
            'section_code'=>NULL,
            'name'=>'Consultant\'s Attendant',
            'short_name'=>'CA',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'14140@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:32:45',
            'updated_at'=>'2019-01-27 05:32:45'
        ] );



        Section::create( [
            'id'=>3,
            'company_id'=>1,
            'department_id'=>14,
            'section_code'=>NULL,
            'name'=>'Report Delivery',
            'short_name'=>'RD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'79590@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:33:28',
            'updated_at'=>'2019-01-27 05:33:28'
        ] );



        Section::create( [
            'id'=>4,
            'company_id'=>1,
            'department_id'=>19,
            'section_code'=>NULL,
            'name'=>'X-ray',
            'short_name'=>'X-ray',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'47098@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:33:56',
            'updated_at'=>'2019-01-27 05:33:56'
        ] );



        Section::create( [
            'id'=>5,
            'company_id'=>1,
            'department_id'=>19,
            'section_code'=>NULL,
            'name'=>'ECG/ETT/Echo Technician',
            'short_name'=>'ECT/ETT/Echo',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'86078@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:37:24',
            'updated_at'=>'2019-01-27 05:37:24'
        ] );



        Section::create( [
            'id'=>6,
            'company_id'=>1,
            'department_id'=>6,
            'section_code'=>NULL,
            'name'=>'OPD Cash & Appointment Desk',
            'short_name'=>'OPD Cash',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'82339@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:03:17',
            'updated_at'=>'2019-01-27 06:03:17'
        ] );



        Section::create( [
            'id'=>7,
            'company_id'=>1,
            'department_id'=>6,
            'section_code'=>NULL,
            'name'=>'IPD Billing',
            'short_name'=>'IPD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'21395@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:03:40',
            'updated_at'=>'2019-01-27 06:03:40'
        ] );



        Section::create( [
            'id'=>8,
            'company_id'=>1,
            'department_id'=>7,
            'section_code'=>NULL,
            'name'=>'Material Store',
            'short_name'=>'Store',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'89476@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:19:17',
            'updated_at'=>'2019-01-27 06:19:17'
        ] );



        Section::create( [
            'id'=>9,
            'company_id'=>1,
            'department_id'=>9,
            'section_code'=>NULL,
            'name'=>'Market Promotion',
            'short_name'=>'Marketing',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'32998@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:20:36',
            'updated_at'=>'2019-01-27 06:20:36'
        ] );



        Section::create( [
            'id'=>10,
            'company_id'=>1,
            'department_id'=>9,
            'section_code'=>NULL,
            'name'=>'Corporate Relation',
            'short_name'=>'CR',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'53022@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:21:24',
            'updated_at'=>'2019-01-27 06:21:24'
        ] );



        Section::create( [
            'id'=>11,
            'company_id'=>1,
            'department_id'=>25,
            'section_code'=>NULL,
            'name'=>'IPD Pharmacy',
            'short_name'=>'IPD Pharmacy',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'62314@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:22:07',
            'updated_at'=>'2019-01-27 06:22:07'
        ] );



        Section::create( [
            'id'=>12,
            'company_id'=>1,
            'department_id'=>25,
            'section_code'=>NULL,
            'name'=>'OPD Pharmacy',
            'short_name'=>'OPD Pharmacy',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'77821@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:22:33',
            'updated_at'=>'2019-01-27 06:22:33'
        ] );



        Section::create( [
            'id'=>13,
            'company_id'=>1,
            'department_id'=>26,
            'section_code'=>NULL,
            'name'=>'F & B Services',
            'short_name'=>'F & B Services',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'65023@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:23:41',
            'updated_at'=>'2019-01-27 06:23:41'
        ] );



        Section::create( [
            'id'=>14,
            'company_id'=>1,
            'department_id'=>26,
            'section_code'=>NULL,
            'name'=>'Kitchen Services',
            'short_name'=>'Kitchen Services',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'44070@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:24:15',
            'updated_at'=>'2019-01-27 06:24:15'
        ] );



        Section::create( [
            'id'=>15,
            'company_id'=>1,
            'department_id'=>26,
            'section_code'=>NULL,
            'name'=>'Room Services',
            'short_name'=>'Room Services',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'78308@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:24:46',
            'updated_at'=>'2019-01-27 06:24:46'
        ] );



        Section::create( [
            'id'=>16,
            'company_id'=>1,
            'department_id'=>26,
            'section_code'=>NULL,
            'name'=>'Waste Management',
            'short_name'=>'Waste Management',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'14797@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:25:13',
            'updated_at'=>'2019-01-27 06:25:13'
        ] );



        Section::create( [
            'id'=>17,
            'company_id'=>1,
            'department_id'=>26,
            'section_code'=>NULL,
            'name'=>'Pest Control Services',
            'short_name'=>'Pest Control Services',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'62465@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:25:45',
            'updated_at'=>'2019-01-27 06:25:45'
        ] );



        Section::create( [
            'id'=>18,
            'company_id'=>1,
            'department_id'=>26,
            'section_code'=>NULL,
            'name'=>'Patient Care Attendant',
            'short_name'=>'PCA',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'60831@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:26:09',
            'updated_at'=>'2019-01-27 06:26:09'
        ] );



        Section::create( [
            'id'=>19,
            'company_id'=>1,
            'department_id'=>26,
            'section_code'=>NULL,
            'name'=>'House Keeping Services',
            'short_name'=>'H/K',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'21514@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:30:09',
            'updated_at'=>'2019-01-27 06:30:09'
        ] );




    }
}
