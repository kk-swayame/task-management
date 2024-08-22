<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Admin1',
            'email' => 'admin@gmail.com',
            'email_verified_at' => null,
            'password' => '$2y$12$dvBXBaj6lA/LUBdhR7yJ5uC3Dj46i2u1Y0fio0wagQ/99swixxgs.', // Hashed password
            'role' => 'admin',
            'flag' => 0,
            'remember_token' => null,
            'created_at' => '2024-08-22 11:58:05',
            'updated_at' => '2024-08-22 12:45:30',
        ]);
    }
}
