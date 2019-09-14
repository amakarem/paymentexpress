<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateamazonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner');
            $table->string('merchantId')->unique();
            $table->string('accessKey')->default(0);
            $table->string('secretKey')->default(0);
            $table->string('clientid')->default(0);
            $table->string('sandbox', 1)->default(0);
            $table->string('disabled', 1)->default(0);
            $table->string('callback')->nullable();
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
        Schema::dropIfExists('amazon');
    }
}
