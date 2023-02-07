<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_professionals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('emp_personals_id')->unsigned()->unique();
            $table->foreign('emp_personals_id')->references('id')->on('emp_personals')->onDelete('RESTRICT');
            $table->integer('division_id')->unsigned()->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('RESTRICT');
            $table->integer('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('RESTRICT');
            $table->integer('section_id')->unsigned()->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->integer('employee_id')->unique()->unsigned();
            $table->integer('pf_no')->unsigned()->default(0);
            $table->integer('designation_id')->unsigned();
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('RESTRICT');
            $table->integer('report_to')->unsigned()->nullable();
            $table->date('joining_date')->nullable();
            $table->string('card_no',30)->nullable();
            $table->boolean('card_printed')->default(0);
            $table->boolean('overtime')->default(0)->comment('Overtime Eligibility');
            $table->string('overtime_note',999)->default(0)->comment('Overtime Instructions')->nullable();
            $table->boolean('transport')->default(0)->comment('Transport Eligibility');
            $table->string('transport_note',999)->comment('Transport Instructions')->nullable();
            $table->integer('pay_schale')->unsigned()->default(0);
            $table->string('pay_grade',50)->nullable();
            $table->integer('working_status_id')->unsigned();
            $table->foreign('working_status_id')->references('id')->on('working_statuses')->onDelete('RESTRICT');
            $table->char('confirm_probation',1)->default('P');
            $table->integer('confirm_period')->unsigned()->default(0);
            $table->integer('bank_id')->unsigned()->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('RESTRICT');
            $table->char('bank_acc_no',17)->nullable();
            $table->date('status_change_date')->nullable();
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
        Schema::dropIfExists('emp_professionals');
    }
}
