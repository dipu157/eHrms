<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('division_code')->nullable()->unsigned();
            $table->string('name',200);
            $table->char('short_name',25);
            $table->string('description',240)->nullable();
            $table->date('started_from')->default(\Carbon\Carbon::now());
            $table->integer('report_to')->unsigned()->nullable();
            $table->integer('approval_authority')->unsigned()->nullable();
            $table->integer('headed_by')->unsigned()->nullable();
            $table->integer('second_man')->unsigned()->nullable();
            $table->string('email',190)->nullable()->unique();
            $table->boolean('status')->default(1);
            $table->integer('emp_count')->unsigned()->default(0);
            $table->integer('approved_manpower')->unsigned()->default(0);
            $table->integer('top_rank')->unsigned()->default(0);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['company_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
}
