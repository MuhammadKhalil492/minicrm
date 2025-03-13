<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\RoleEnum;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'secret'
        ])->syncRoles([RoleEnum::ADMIN]);
    }
}
