<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::create('delivery_times', function (Blueprint $table) {
        $table->bigIncrements('id')->nullable(false);
        $table->integer('curriculums_id')->nullable(false);
        $table->dateTime('delivery_from')->nullable(false);
        $table->dateTime('delivery_to')->nullable(false);
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
        Schema::dropIfExists('delivery_times');
    }
};
