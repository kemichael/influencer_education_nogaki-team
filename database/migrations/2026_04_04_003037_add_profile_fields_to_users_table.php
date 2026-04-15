<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name_kana')->nullable()->after('name');
            $table->string('profile_image')->nullable()->after('password');
            $table->foreignId('grade_id')
                ->nullable()
                ->after('profile_image')
                ->constrained('classes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('grade_id');
            $table->dropColumn(['name_kana', 'profile_image']);
        });
    }
};