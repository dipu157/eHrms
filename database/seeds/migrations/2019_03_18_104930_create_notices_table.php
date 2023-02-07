<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('RESTRICT');
            $table->date('notice_date')->default(Carbon\Carbon::now()->format('Y-m-d'));
            $table->date('expiry_date')->nullable();
            $table->string('title',240);
            $table->mediumText('description')->nullable();
            $table->string('sender',240);
            $table->char('type',1)->default('D')->comment('D=>Display E=>Email');
            $table->char('confidentiality',1)->default('P')->comment('P=>Public C=>Confidential');
            $table->char('receiver',1)->default('A')->comment('A=>all; P=>Person D=>Department');
            $table->string('file_path',240)->nullable();
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
        Schema::dropIfExists('notices');
    }
}
