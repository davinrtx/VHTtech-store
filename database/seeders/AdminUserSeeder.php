<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@vhttech.com')->first();

        if (! $admin) {
            $admin = User::factory()->create([
                'name' => 'Admin VHTtech',
                'email' => 'admin@vhttech.com',
                'password' => bcrypt('admin123'),
                'is_admin' => true,
            ]);
        }

        $admin->assignRole('super_admin');
    }
}
