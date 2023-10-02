<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'All privilegies']);
        Role::create(['name' => 'moderator', 'description' => 'Admin without creating orders']);
        Role::create(['name' => 'place', 'description' => 'Can create, delete, edit orders']);
        Role::create(['name' => 'courier', 'description' => 'Can take orders']);
    }
}
