<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->year('r_year');
            $table->integer('month_id')->unsigned();
            $table->integer('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('RESTRICT');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('employee_id')->on('emp_professionals')->onDelete('RESTRICT');
            $table->integer('day_01')->unsigned()->nullable();
            $table->foreign('day_01')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_02')->unsigned()->nullable();
            $table->foreign('day_02')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_03')->unsigned()->nullable();
            $table->foreign('day_03')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_04')->unsigned()->nullable();
            $table->foreign('day_04')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_05')->unsigned()->nullable();
            $table->foreign('day_05')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_06')->unsigned()->nullable();
            $table->foreign('day_06')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_07')->unsigned()->nullable();
            $table->foreign('day_07')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('loc_01')->unsigned()->nullable();
            $table->foreign('loc_01')->references('id')->on('duty_locations')->onDelete('RESTRICT');
            $table->integer('day_08')->unsigned()->nullable();
            $table->foreign('day_08')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_09')->unsigned()->nullable();
            $table->foreign('day_09')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_10')->unsigned()->nullable();
            $table->foreign('day_10')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_11')->unsigned()->nullable();
            $table->foreign('day_11')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_12')->unsigned()->nullable();
            $table->foreign('day_12')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_13')->unsigned()->nullable();
            $table->foreign('day_13')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_14')->unsigned()->nullable();
            $table->foreign('day_14')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('loc_02')->unsigned()->nullable();
            $table->foreign('loc_02')->references('id')->on('duty_locations')->onDelete('RESTRICT');
            $table->integer('day_15')->unsigned()->nullable();
            $table->foreign('day_15')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_16')->unsigned()->nullable();
            $table->foreign('day_16')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_17')->unsigned()->nullable();
            $table->foreign('day_17')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_18')->unsigned()->nullable();
            $table->foreign('day_18')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_19')->unsigned()->nullable();
            $table->foreign('day_19')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_20')->unsigned()->nullable();
            $table->foreign('day_20')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_21')->unsigned()->nullable();
            $table->foreign('day_21')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('loc_03')->unsigned()->nullable();
            $table->foreign('loc_03')->references('id')->on('duty_locations')->onDelete('RESTRICT');
            $table->integer('day_22')->unsigned()->nullable();
            $table->foreign('day_22')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_23')->unsigned()->nullable();
            $table->foreign('day_23')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_24')->unsigned()->nullable();
            $table->foreign('day_24')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_25')->unsigned()->nullable();
            $table->foreign('day_25')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_26')->unsigned()->nullable();
            $table->foreign('day_26')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_27')->unsigned()->nullable();
            $table->foreign('day_27')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_28')->unsigned()->nullable();
            $table->foreign('day_28')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('loc_04')->unsigned()->nullable();
            $table->foreign('loc_04')->references('id')->on('duty_locations')->onDelete('RESTRICT');
            $table->integer('day_29')->unsigned()->nullable();
            $table->foreign('day_29')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_30')->unsigned()->nullable();
            $table->foreign('day_30')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('day_31')->unsigned()->nullable();
            $table->foreign('day_31')->references('id')->on('shifts')->onDelete('RESTRICT');
            $table->integer('loc_05')->unsigned()->nullable();
            $table->foreign('loc_05')->references('id')->on('duty_locations')->onDelete('RESTRICT');
            $table->integer('inserted_by')->unsigned();
            $table->foreign('inserted_by')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('inserted_date')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('approved_by')->unsigned()->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('approved_date')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('updated_date')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('rosters');
    }
}
