<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatepaypalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner');
            $table->string('email')->unique();
            $table->string('username')->default(0);
            $table->string('password')->default(0);
            $table->string('secret')->default(0);
            $table->string('certificate')->default(0);
            $table->string('app_id')->default(0);
            $table->string('sandbox', 1)->default(0);
            $table->string('disabled', 1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal');
    }
}
