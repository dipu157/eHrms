<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_setups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('employee_id')->on('emp_professionals')->onDelete('RESTRICT');
            $table->date('ot_date');
            $table->char('ot_type',1)->default('S');
            $table->time('entry_time')->nullable();
            $table->date('exit_date')->nullable();
            $table->time('exit_time')->nullable();
            $table->integer('ot_hour')->default(0);
            $table->integer('overtime_from_punch')->default(0);
            $table->integer('actual_overtime_hour')->default(0);
            $table->mediumText('reason');
            $table->boolean('dusty_status')->default(0); // whether did or not
            $table->boolean('approval_status')->default(0);
            $table->integer('approver_id')->unsigned()->nullable();
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->integer('finalize_by')->unsigned()->nullable();
            $table->foreign('finalize_by')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('finalize_at')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('overtime_setups');
    }
}
