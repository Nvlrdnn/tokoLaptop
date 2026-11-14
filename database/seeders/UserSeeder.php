<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Admin Gudang
        User::create([
            'name'     => 'Admin Gudang',
            'email'    => 'admin@toko.com',
            'password' => Hash::make('gudang111'),
            'role'     => 'admin_gudang',
        ]);

        // 2. Akun Kasir
        User::create([
            'name'     => 'Kasir Toko',
            'email'    => 'kasir@toko.com',
            'password' => Hash::make('kasir321'),
            'role'     => 'kasir',
        ]);

        // 3. Akun Bos / Owner
        User::create([
            'name'     => 'Big Boss',
            'email'    => 'bos@toko.com',
            'password' => Hash::make('bos123'),
            'role'     => 'bos',
        ]);
    }
}