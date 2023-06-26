<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                'name'           => 'Administrator',
                'email'          => 'admin@admin',
                'password'       => bcrypt('adminadmin'),
                'remember_token' => null,
            ]
        ];

    User::insert($users);

    }
}
