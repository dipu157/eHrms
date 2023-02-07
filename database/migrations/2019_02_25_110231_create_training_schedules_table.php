<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('training_id')->unsigned();
            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('RESTRICT');
            $table->mediumText('trainer',999)->nullable();
            $table->timestamp('start_from')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_on')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->mediumText('description',999)->nullable();
            $table->integer('participants')->unsigned()->default(0);
            $table->integer('attended')->unsigned()->default(0);
            $table->mediumText('closing_notes',999)->nullable();
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
        Schema::dropIfExists('training_schedules');
    }
}
