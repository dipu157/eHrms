<?php

use Illuminate\Database\Seeder;
use App\Models\Common\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create( [
            'id'=>1,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>1,
            'name'=>'Hospital Administration',
            'short_name'=>'HA',
            'description'=>NULL,
            'started_from'=>'2019-01-24',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'41001@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-24 11:41:25',
            'updated_at'=>'2019-01-24 11:41:25'
        ] );



        Department::create( [
            'id'=>2,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>2,
            'name'=>'HR & Admin',
            'short_name'=>'HR',
            'description'=>NULL,
            'started_from'=>'2019-01-26',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'30835@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-24 12:00:46',
            'updated_at'=>'2019-01-26 04:27:16'
        ] );



        Department::create( [
            'id'=>3,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>3,
            'name'=>'Safety & Security',
            'short_name'=>'SS',
            'description'=>NULL,
            'started_from'=>'2019-01-24',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'50834@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-24 12:01:33',
            'updated_at'=>'2019-01-24 12:01:33'
        ] );



        Department::create( [
            'id'=>4,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>4,
            'name'=>'Transport Services',
            'short_name'=>'TS',
            'description'=>NULL,
            'started_from'=>'2019-01-24',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'71852@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-24 12:02:20',
            'updated_at'=>'2019-01-24 12:02:20'
        ] );



        Department::create( [
            'id'=>5,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>5,
            'name'=>'Information Technology',
            'short_name'=>'IT',
            'description'=>NULL,
            'started_from'=>'2019-01-24',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'57954@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-24 12:03:05',
            'updated_at'=>'2019-01-24 12:03:05'
        ] );



        Department::create( [
            'id'=>6,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>6,
            'name'=>'Finance & Accounts',
            'short_name'=>'F & A',
            'description'=>NULL,
            'started_from'=>'2019-01-24',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'65661@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>'CFO',
            'user_id'=>2,
            'created_at'=>'2019-01-24 12:04:06',
            'updated_at'=>'2019-01-24 12:04:06'
        ] );



        Department::create( [
            'id'=>7,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>9,
            'name'=>'Supply Chain Management',
            'short_name'=>'SCM',
            'description'=>NULL,
            'started_from'=>'2019-01-24',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'90234@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-24 12:07:28',
            'updated_at'=>'2019-01-24 12:07:28'
        ] );



        Department::create( [
            'id'=>8,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>20,
            'name'=>'Engineering & Maintenance',
            'short_name'=>'EM',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'55171@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>'AGM',
            'user_id'=>2,
            'created_at'=>'2019-01-27 03:56:49',
            'updated_at'=>'2019-01-27 03:56:49'
        ] );



        Department::create( [
            'id'=>9,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>29,
            'name'=>'Business Development',
            'short_name'=>'BD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'83430@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 03:57:39',
            'updated_at'=>'2019-01-27 03:57:39'
        ] );



        Department::create( [
            'id'=>10,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>30,
            'name'=>'Internal Control (Costing & Auditing)',
            'short_name'=>'ICCA',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'13148@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 03:58:59',
            'updated_at'=>'2019-01-27 03:58:59'
        ] );



        Department::create( [
            'id'=>11,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>31,
            'name'=>'Brand Communication',
            'short_name'=>'BC',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'73114@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 04:00:03',
            'updated_at'=>'2019-01-27 04:00:03'
        ] );



        Department::create( [
            'id'=>12,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>13,
            'name'=>'HVAC Department',
            'short_name'=>'HVAC',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'58048@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 04:00:59',
            'updated_at'=>'2019-01-27 04:00:59'
        ] );



        Department::create( [
            'id'=>13,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>7,
            'name'=>'Clinical Services Department',
            'short_name'=>'CSD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'90134@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>'DHS / CEO',
            'user_id'=>2,
            'created_at'=>'2019-01-27 04:03:12',
            'updated_at'=>'2019-01-27 05:25:10'
        ] );



        Department::create( [
            'id'=>14,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>8,
            'name'=>'Customer Care Services',
            'short_name'=>'CCS',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'21864@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 04:26:22',
            'updated_at'=>'2019-01-27 05:25:27'
        ] );



        Department::create( [
            'id'=>15,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>10,
            'name'=>'Biomedical Engineering Department',
            'short_name'=>'BED',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'94733@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 04:50:15',
            'updated_at'=>'2019-01-27 04:50:15'
        ] );



        Department::create( [
            'id'=>16,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>11,
            'name'=>'Medical Secretary Department',
            'short_name'=>'MSD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'14853@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:02:12',
            'updated_at'=>'2019-01-27 05:02:12'
        ] );



        Department::create( [
            'id'=>17,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>12,
            'name'=>'Nursing Services Department',
            'short_name'=>'NSD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'15508@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:03:19',
            'updated_at'=>'2019-01-27 05:03:19'
        ] );



        Department::create( [
            'id'=>18,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>14,
            'name'=>'Laboratory Medicine Department',
            'short_name'=>'LMD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'71334@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:04:32',
            'updated_at'=>'2019-01-27 05:04:32'
        ] );



        Department::create( [
            'id'=>19,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>15,
            'name'=>'Radiology & Imaging Department',
            'short_name'=>'R & I',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'89880@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:06:18',
            'updated_at'=>'2019-01-27 05:06:18'
        ] );



        Department::create( [
            'id'=>20,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>16,
            'name'=>'Clinical Procedure Department',
            'short_name'=>'CPD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'78534@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:07:40',
            'updated_at'=>'2019-01-27 05:07:40'
        ] );



        Department::create( [
            'id'=>21,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>18,
            'name'=>'Operation Theatre Department',
            'short_name'=>'OTD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'73906@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:18:02',
            'updated_at'=>'2019-01-27 05:18:02'
        ] );




        Department::create( [
            'id'=>22,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>17,
            'name'=>'Medical Record Department',
            'short_name'=>'MRD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'59856@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:18:43',
            'updated_at'=>'2019-01-27 05:18:43'
        ] );



        Department::create( [
            'id'=>23,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>21,
            'name'=>'Central Sterile Services Department',
            'short_name'=>'CSSD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'12747@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:22:52',
            'updated_at'=>'2019-01-27 05:22:52'
        ] );



        Department::create( [
            'id'=>24,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>22,
            'name'=>'Dialysis Department',
            'short_name'=>'DD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'37599@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:27:08',
            'updated_at'=>'2019-01-27 05:27:08'
        ] );



        Department::create( [
            'id'=>25,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>24,
            'name'=>'Pharmacy Department',
            'short_name'=>'PD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'48409@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:28:43',
            'updated_at'=>'2019-01-27 05:28:43'
        ] );



        Department::create( [
            'id'=>26,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>25,
            'name'=>'Hospitality & Support Services Department',
            'short_name'=>'HSSD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'96424@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:29:35',
            'updated_at'=>'2019-01-27 05:29:35'
        ] );



        Department::create( [
            'id'=>27,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>26,
            'name'=>'Dietetics Department',
            'short_name'=>'Dietetics',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'62545@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 05:59:37',
            'updated_at'=>'2019-01-27 05:59:37'
        ] );



        Department::create( [
            'id'=>28,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>27,
            'name'=>'Linen & Laundry Department',
            'short_name'=>'Linen',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'59914@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:00:39',
            'updated_at'=>'2019-01-27 06:00:39'
        ] );



        Department::create( [
            'id'=>29,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>19,
            'name'=>'Transfusion Medicine Department',
            'short_name'=>'TMD',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'99322@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:01:16',
            'updated_at'=>'2019-01-27 06:01:16'
        ] );



        Department::create( [
            'id'=>30,
            'company_id'=>1,
            'division_id'=>2,
            'department_code'=>23,
            'name'=>'Quality & Infection Control Department',
            'short_name'=>'Quality',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'31406@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:01:55',
            'updated_at'=>'2019-01-27 06:01:55'
        ] );



        Department::create( [
            'id'=>31,
            'company_id'=>1,
            'division_id'=>1,
            'department_code'=>28,
            'name'=>'Physiotherapy Department',
            'short_name'=>'Physiotherapy',
            'description'=>NULL,
            'started_from'=>'2019-01-27',
            'report_to'=>NULL,
            'approval_authority'=>NULL,
            'headed_by'=>NULL,
            'second_man'=>NULL,
            'email'=>'56745@brbhospital.com',
            'status'=>1,
            'emp_count'=>0,
            'approved_manpower'=>0,
            'top_rank'=>NULL,
            'user_id'=>2,
            'created_at'=>'2019-01-27 06:02:24',
            'updated_at'=>'2019-01-27 06:02:24'
        ] );




    }
}
