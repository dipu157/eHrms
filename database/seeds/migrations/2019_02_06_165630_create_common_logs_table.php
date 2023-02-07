<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('usecase_id')->unsigned()->default(1);
            $table->foreign('usecase_id')->references('id')->on('use_cases')->onDelete('RESTRICT');
            $table->char('entry_type',1)->default('E')->comment('A=ADD, E=Edit');
            $table->string('table_name',200);
            $table->mediumText('old_data')->nullable();
            $table->mediumText('new_data');
            $table->mediumText('description');
            $table->ipAddress('user_ip');
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
        Schema::dropIfExists('common_logs');
    }
}
