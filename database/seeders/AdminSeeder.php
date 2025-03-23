<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
            $this->command->error('Please set ADMIN_NAME, ADMIN_EMAIL AND ADMIN_PASSWORD in .env file');
            return;
        }

        if (Role::doesntExist()) {
            $this->call(RoleSeeder::class);
        }

        $role = Role::where('title', 'admin')->first();

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
