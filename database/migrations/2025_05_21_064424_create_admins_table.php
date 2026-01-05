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
    Schema::create('admins', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name', 255); 
        $table->string('kana', 255); 
        $table->string('email', 255)->unique(); 
        $table->string('password');
        $table->timestamp('created_at')->useCurrent(); 
        $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate(); 
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
