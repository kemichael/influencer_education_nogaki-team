<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SchoolClass::DEFAULT_NAMES as $name) {
            SchoolClass::query()->firstOrCreate([
                'name' => $name,
            ]);
        }
    }
}
