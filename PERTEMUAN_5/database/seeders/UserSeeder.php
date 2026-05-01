<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roleAdmin    = Role::firstOrCreate(['name' => 'admin']);
        $roleStaff    = Role::firstOrCreate(['name' => 'staff']);

        $cokomi = User::firstOrCreate(
            ['email' => 'cokomi@toko.com'],
            [
                'name'              => 'Pak Cokomi',
                'password'          => Hash::make('cokomi123'),
                'email_verified_at' => now(),
            ]
        );
        $cokomi->assignRole($roleAdmin);

        $wowo = User::firstOrCreate(
            ['email' => 'wowo@toko.com'],
            [
                'name'              => 'Mas Wowo',
                'password'          => Hash::make('wowo123'),
                'email_verified_at' => now(),
            ]
        );
        $wowo->assignRole($roleStaff);

        $this->command->info('Role admin, staff & customer berhasil dibuat!');
    }
}