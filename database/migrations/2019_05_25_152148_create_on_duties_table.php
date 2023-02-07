<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnDutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_duties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->year('duty_year');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('employee_id')->on('emp_professionals')->onDelete('RESTRICT');
            $table->date('from_date');
            $table->date('to_date');
            $table->smallInteger('nods')->default(0)->unsigned();
            $table->mediumText('duty_place')->nullable();
            $table->char('application_time')->default('B')->comment('B=Before A=After');
            $table->mediumText('reason')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->integer('recommend_id')->unsigned()->nullable();
            $table->foreign('recommend_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('recommend_date')->nullable();
            $table->integer('approver_id')->unsigned()->nullable();
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('approve_date')->nullable();
            $table->mediumText('description')->nullable();
            $table->char('posted',1)->default(0);
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
        Schema::dropIfExists('on_duties');
    }
}
