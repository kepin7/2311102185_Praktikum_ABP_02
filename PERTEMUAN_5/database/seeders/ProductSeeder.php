<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()->count(15)->create();

        Product::factory()->count(3)->lowStock()->create();

        Product::factory()->count(2)->outOfStock()->create();

        $total = Product::count();
        $this->command->info("{$total} produk berhasil dibuat di database!");
    }
}