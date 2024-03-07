<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->create();

         \App\Models\User::create([
             'first_name' => 'admin',
             'last_name' => 'admin',
             'role' => 'admin', // Default role is customer
             'email' => "admin@admin.com",
             'email_verified_at' => now(),
             'mobile'=> fake()->phoneNumber(),
             'password' => bcrypt('123'),
             'remember_token' => Str::random(10),
         ]);
    }
}
