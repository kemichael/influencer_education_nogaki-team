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
    Schema::create('curriculums', function (Blueprint $table) {
        $table->bigIncrements('id')->nullable(false);
        $table->string('title')->nullable(false);
        $table->string('thumbnail');
        $table->text('description');
        $table->text('video_url');
        $table->tinyInteger('alway_delivery_flg')->nullable(false);
        $table->integer('grade_id')->nullable(false);
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
        Schema::dropIfExists('curriculums');
    }
};
