<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsCircularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants_circular', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            
            $table->integer('circular_id')->unsigned()->default(1); //section
            $table->foreign('circular_id')->references('id')->on('job_circular')->onDelete('RESTRICT');

            $table->integer('applicants_id')->unsigned()->default(1); //section
            $table->foreign('applicants_id')->references('id')->on('applicants')->onDelete('RESTRICT');

            $table->integer('status_id')->unsigned()->default(1); //section
            $table->foreign('status_id')->references('id')->on('applicants_status_list')->onDelete('RESTRICT');


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
        Schema::dropIfExists('applicants_circular');
    }
}
