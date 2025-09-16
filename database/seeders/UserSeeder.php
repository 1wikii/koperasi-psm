<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@koperasipsm.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin'
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@koperasipsm.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }
}
