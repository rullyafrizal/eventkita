<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'Admin123',
                'phone' => '081234567890'
            ],
            [
                'name' => 'Partner 1',
                'email' => 'partner1@gmail.com',
                'password' => 'Partner1_',
                'phone' => '081234567888'
            ]
        ];

        User::query()
            ->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('Admin123'),
                'phone' => '081234567890'
            ]);
    }
}
