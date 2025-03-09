<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = config('auth.admin.name');
        $email = config('auth.admin.email');
        $password = config('auth.admin.password');

        if (empty($name) || empty($email) || empty($password)) {
            throw new \Exception('Please set ADMIN_NAME, ADMIN_EMAIL AND ADMIN_PASSWORD in .env file');
        }

        $role = Role::where('title', 'admin')->first();
        if (!$role) {
            throw new \Exception('Please run RoleSeeder first');
        }

        $admin = User::updateOrCreate([
            'email' => $email,
        ], [
            'name' => $name,
            'password' => bcrypt($password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $admin->roles()->attach($role);
    }
}
