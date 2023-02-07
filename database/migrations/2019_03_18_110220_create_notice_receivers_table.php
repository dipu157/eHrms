<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_receivers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('notice_id')->unsigned();
            $table->foreign('notice_id')->references('id')->on('notices')->onDelete('RESTRICT');
            $table->integer('r_department_id')->unsigned()->nullable();
            $table->foreign('r_department_id')->references('id')->on('departments')->onDelete('CASCADE');
            $table->integer('r_employee_id')->unsigned()->nullable();
            $table->foreign('r_employee_id')->references('employee_id')->on('emp_professionals')->onDelete('CASCADE');
            $table->string('r_email',200)->nullable();
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
        Schema::dropIfExists('notice_receivers');
    }
}
