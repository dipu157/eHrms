<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('employee_id')->on('emp_professionals')->onDelete('RESTRICT');
            $table->integer('department_id')->unsigned()->default(1);
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('RESTRICT');
            $table->string('device_id',50)->nullable();
            $table->timestamp('attendance_datetime')->nullable();
            $table->date('attend_date');
            $table->date('entry_date')->nullable();
            $table->time('entry_time')->nullable();
            $table->time('shift_entry_time');
            $table->date('exit_date')->nullable();
            $table->time('exit_time')->nullable();
            $table->time('shift_exit_time');
            $table->char('attend_status',1)->comment('P=Present A=>Absent O=Offday L=Leave H=>HolyDay');
            $table->boolean('night_duty')->default(0);
            $table->boolean('late_flag')->default(0);
            $table->boolean('late_allow')->default(0);
            $table->integer('late_minute')->default(0);
            $table->boolean('over_time')->default(0);
            $table->integer('overtime_hour')->default(0);
            $table->boolean('leave_flag')->default(0);
            $table->integer('leave_id')->default(0);
            $table->boolean('holiday_flag')->default(0);
            $table->boolean('offday_flag')->default(0);
            $table->boolean('offday_present')->default(0);
            $table->integer('shift_id')->unsigned();
            $table->boolean('in_process')->default(0);
            $table->char('compensate',1)->nullable();
            $table->date('alter_leave_date')->nullable();
            $table->boolean('manual_update')->default(0);
            $table->integer('manual_updated_by')->unsigned()->nullable();
            $table->string('manual_update_remarks',250)->nullable();
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
        Schema::dropIfExists('daily_attendances');
    }
}
