<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'produksi', 'gudang', 'manager'];
        
        foreach ($roles as $role) {
            User::create([
                'name' => ucfirst($role) . ' User',
                'username' => $role,
                'email' => $role . '@admin.com',
                'password' => Hash::make('password'),
                'role' => $role,
            ]);
        }
    }
}
