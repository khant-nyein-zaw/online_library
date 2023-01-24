<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\Role::factory()->create([
            'role_name' => 'Admin',
        ]);

        \App\Models\Role::factory()->create([
            'role_name' => 'Member',
        ]);

        \App\Models\Role::factory()->create([
            'role_name' => 'Visitor',
        ]);
    }
}
