<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use App\Models\Auth\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'name' => 'Administrator',
            'slug' => 'admin'
        ]);

        UserRole::create([
            'name' => 'User',
            'slug' => 'user'
        ]);

        $roleAdminId = UserRole::getIdBySlug('admin');
        $roleUserId = UserRole::getIdBySlug('user');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role_id' => $roleAdminId
        ]);

        User::create([
            'name' => 'Alesha',
            'email' => 'alesha@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role_id' => $roleUserId
        ]);
    }
}
