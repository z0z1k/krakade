<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;

class RootUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'z0z1k8k@gmail.com',
            'phone' => '0933813352',
            'password' => Hash::make('123456')
        ];

        $user = User::create($data);

        $user->roles()->sync(Role::where('name', 'admin')->get());
    }
}
