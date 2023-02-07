<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgCalendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_calenders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->year('calender_year');
            $table->unsignedSmallInteger('month_id',false);
            $table->char('c_month_id',2);
            $table->string('month_name',10);
            $table->date('start_from');
            $table->date('ends_on');
            $table->char('salary_open',1)->default('F')->comment('F=Future, O=Open, C=Close');
            $table->char('salary_update',1)->default('F')->comment('F=Future, O=Open, C=Close');
            $table->char('food_open',1)->default('F')->comment('F=Future, O=Open, C=Close');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('org_calenders');
    }
}
