<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            
            $table->string('full_name',150);
            $table->string('photo',150)->nullable();
            $table->string('email',190)->nullable();
            $table->string('pr_address',240)->comment('Present Address');
            $table->string('pr_district',25);
            $table->string('pr_post_code',4);
            $table->string('mobile',150)->nullable();
            $table->string('father_name',100)->nullable();
            $table->string('mother_name',100)->nullable();
            $table->string('spouse_name',100)->nullable();
            $table->date('dob')->nullable();
            $table->char('gender',1)->comments('M=> Male F=>Female');
            $table->string('ssc_roll',20)->nullable();
            $table->string('national_id',20)->nullable();
            $table->boolean('is_printed')->default(0);
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
        Schema::dropIfExists('applicants');
    }
}
