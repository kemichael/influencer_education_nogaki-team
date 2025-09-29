<?php

namespace Database\Seeders;

use App\Models\Admin;  
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => '管理者',
            'kana' => 'カンリシャ',
            'email' => '123abc@gmail.com',
            'password' => Hash::make('123abcef'),
        ]);
    }
}