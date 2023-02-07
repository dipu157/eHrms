<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpPostingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_posting_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('emp_personals_id')->unsigned();
            $table->foreign('emp_personals_id')->references('id')->on('emp_personals')->onDelete('RESTRICT');
            $table->integer('division_id')->unsigned();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('RESTRICT');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('RESTRICT');
            $table->integer('section_id')->unsigned()->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->integer('report_to')->unsigned();
            $table->foreign('report_to')->references('id')->on('emp_personals')->onDelete('RESTRICT');
            $table->date('posting_start_date');
            $table->date('posting_end_date')->nullable();
            $table->char('charge_type',1)->default('G');
            $table->string('special')->nullable();
            $table->string('posting_notes',240)->nullable();
            $table->string('descriptions',240)->nullable();
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
        Schema::dropIfExists('emp_posting_histories');
    }
}
