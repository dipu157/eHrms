<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalarySetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_setups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->default(1);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->integer('employee_id')->unsigned()->unique();
            $table->foreign('employee_id')->references('employee_id')->on('emp_professionals')->onDelete('RESTRICT');
            $table->decimal('basic',15,2)->default(0);
            $table->decimal('house_rent',15,2)->default(0);
            $table->decimal('medical',15,2)->default(0);
            $table->decimal('entertainment',15,2)->default(0);
            $table->decimal('conveyance',15,2)->default(0);
            $table->decimal('food',15,2)->default(0);
            $table->decimal('special_allowance',15,2)->default(0);
            $table->decimal('others',15,2)->default(0);
            $table->decimal('other_details',15,2)->default(0);
            $table->decimal('extra_col1',15,2)->default(0);
            $table->decimal('extra_col2',15,2)->default(0);
            $table->decimal('extra_col3',15,2)->default(0);
            $table->decimal('pf_own',15,2)->default(0);
            $table->decimal('income_tax',15,2)->default(0);
            $table->decimal('salary_advance',15,2)->default(0);
            $table->decimal('punishment',15,2)->default(0);
            $table->decimal('other_deduction',15,2)->default(0);
            $table->mediumText('other_deduction_details')->nullable();
            $table->decimal('last_month_salary',15,2)->default(0);
            $table->integer('checker_id')->unsigned()->nullable();
            $table->foreign('checker_id')->references('id')->on('users')->onDelete('RESTRICT');
            $table->timestamp('check_date')->nullable()->default(null);
            $table->boolean('check_status')->default(0);
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
        Schema::dropIfExists('salary_setups');
    }
}
