<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(GroupCompanySeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(DivisionTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(SectionTableSeeder::class);
//        $this->call(ReligionTableSeeder::class);
//        $this->call(WorkingStatusTableSeeder::class);
//        $this->call(UseCaseTableSeeder::class);
//        $this->call(LeaveMasterTableSeeder::class);
//        $this->call(ShiftTableSeeder::class);


    }

}
