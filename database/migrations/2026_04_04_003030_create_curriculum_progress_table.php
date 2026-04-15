<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculum_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->boolean('clear_flg')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'curriculum_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_progress');
    }
};
