<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->year('leave_year');
            $table->integer('emp_personals_id')->unsigned();
            $table->foreign('emp_personals_id')->references('id')->on('emp_personals')->onDelete('RESTRICT');
            $table->integer('leave_id')->unsigned();
            $table->foreign('leave_id')->references('id')->on('leave_master')->onDelete('RESTRICT');
            $table->date('from_date');
            $table->date('to_date');
            $table->smallInteger('nods')->default(0)->unsigned();
            $table->date('duty_date')->nullable();
            $table->char('application_time')->default('B')->comment('B=Before A=After');
            $table->string('reason')->nullable();
            $table->string('location')->nullable();
            $table->integer('alternate_id')->unsigned()->nullable();
            $table->timestamp('alternate_submit')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->integer('recommend_id')->unsigned()->nullable();
            $table->foreign('recommend_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('recommend_date')->nullable();
            $table->integer('approver_id')->unsigned()->nullable();
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('approve_date')->nullable();
            $table->mediumText('notes')->nullable();
            $table->char('status',1)->default('C')->comment('C = Created, A=Approved, R=Recommended, D=Dismissed, E=Enjoyed, L=Cancel');
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
        Schema::dropIfExists('leave_applications');
    }
}
