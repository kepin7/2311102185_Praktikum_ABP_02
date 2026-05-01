<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Mulai seeding database toko Pak Cokomi...');

        $this->call([
            UserSeeder::class,    
            ProductSeeder::class, 
        ]);

        $this->command->info('Seeding selesai! Toko siap beroperasi.');
    }
}