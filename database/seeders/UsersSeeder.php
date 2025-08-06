<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => 3,
            'name' => 'Kief',
            'email' => 'kief.chua@example.com',
            'password' => 'kiefchua123',
        ]);

        User::create([
            'role_id' => 3,
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'test',
        ]);
    }
}
