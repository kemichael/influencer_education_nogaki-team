<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('curriculum_progress')) {
            return;
        }

        Schema::table('curriculum_progress', function (Blueprint $table) {
            if (! Schema::hasColumn('curriculum_progress', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('curriculum_progress', 'curriculum_id')) {
                $table->foreignId('curriculum_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('curriculums')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('curriculum_progress', 'clear_flg')) {
                $table->boolean('clear_flg')
                    ->default(false)
                    ->after('curriculum_id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('curriculum_progress')) {
            return;
        }

        Schema::table('curriculum_progress', function (Blueprint $table) {
            if (Schema::hasColumn('curriculum_progress', 'curriculum_id')) {
                $table->dropConstrainedForeignId('curriculum_id');
            }

            if (Schema::hasColumn('curriculum_progress', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }

            if (Schema::hasColumn('curriculum_progress', 'clear_flg')) {
                $table->dropColumn('clear_flg');
            }
        });
    }
};
