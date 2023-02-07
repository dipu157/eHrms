<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiodataCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biodata_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('issue_number')->unique()->unsigned();
            $table->string('name',240);
            $table->string('fathers_name',240);
            $table->string('mothers_name',240);
            $table->string('mobile_no',35)->unique();
            $table->integer('circular_id')->unsigned();
            $table->foreign('circular_id')->references('id')->on('job_circular')->onDelete('RESTRICT');
            $table->string('speciality',200)->nullable();
            $table->date('submission_date')->default(\Carbon\Carbon::now()->format('Y-m-d'));
            $table->mediumText('reference_name')->nullable();
            $table->integer('app_status_id')->unsigned();
            $table->foreign('app_status_id')->references('id')->on('applicants_status_list')->onDelete('RESTRICT');
            $table->string('file_path',240)->nullable();
            $table->date('joining_date')->nullable();
            $table->mediumText('remarks')->nullable();
            $table->unsignedInteger('previous_id')->default(0);
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
        Schema::dropIfExists('biodata_collections');
    }
}
