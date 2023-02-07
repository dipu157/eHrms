<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('employee_id')->on('emp_professionals')->onDelete('RESTRICT');
            $table->integer('period_id')->unsigned();
            $table->foreign('period_id')->references('id')->on('org_calenders')->onDelete('RESTRICT');
            $table->decimal('basic',15,2)->default(0);
            $table->decimal('bonus',15,2)->default(0);
            
            $table->decimal('stamp_fee',15,2)->default(0);
            $table->integer('bank_id')->unsigned()->default(1);
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('RESTRICT');
            
            $table->integer('checker_id')->unsigned()->nullable();
            $table->foreign('checker_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('check_date')->nullable()->default(null);
            $table->boolean('check_status')->default(0);
            
            $table->boolean('withheld')->default(0);
            
            $table->mediumText('remarks')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->boolean('status')->default(1);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unique(['employee_id', 'period_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
