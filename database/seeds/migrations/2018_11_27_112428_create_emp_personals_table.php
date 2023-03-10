<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_personals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('title_id')->unsigned()->nullable();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('RESTRICT');
            $table->integer('religion_id')->unsigned();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('RESTRICT');
            $table->string('first_name',150);
            $table->string('middle_name',150)->nullable();
            $table->string('last_name',150)->nullable();
            $table->string('full_name',150);
            $table->string('photo',150)->nullable();
            $table->string('signature',150)->nullable();
            $table->string('email',190)->nullable();
            $table->string('pr_address',240)->comment('Present Address');
            $table->string('pr_district',25);
            $table->string('pr_police_station',50)->nullable();
            $table->string('pr_post_code',4);
            $table->string('pm_address',240)->nullable()->comment('Permanent Address');
            $table->string('pm_district',25);
            $table->string('pm_police_station',50)->nullable();
            $table->string('pm_post_code',4);
            $table->string('m_address',240)->nullable()->comment('Mailing Address'); //Mailing Address
            $table->string('m_district',25);
            $table->string('m_police_station',50)->nullable();
            $table->string('m_post_code',4);
            $table->string('phone',150)->nullable();
            $table->string('mobile',150)->nullable();
            $table->string('biography',150)->nullable();
            $table->string('father_name',100)->nullable();
            $table->string('mother_name',100)->nullable();
            $table->string('spouse_name',100)->nullable();
            $table->date('dob')->nullable();
            $table->char('gender',1)->comments('M=> Male F=>Female');
            $table->char('blood_group',30)->nullable();
            $table->string('last_education',240)->nullable();
            $table->string('prof_speciality',240)->nullable();
            $table->string('national_id',20)->nullable();
            $table->boolean('is_printed')->default(0);
            $table->boolean('status')->default(1);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emp_personals');
    }
}
