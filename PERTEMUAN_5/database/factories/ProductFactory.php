<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private array $productsByCategory = [
        'Makanan' => [
            'Beras Premium 5kg', 'Mie Goreng Instan', 'Sardines Kaleng', 'Kecap Manis 600ml',
            'Gula Pasir 1kg', 'Minyak Goreng 2L', 'Tepung Terigu 1kg', 'Susu Kental Manis',
            'Kornet Sapi', 'Abon Sapi 100gr',
        ],
        'Minuman' => [
            'Air Mineral 600ml', 'Teh Botol 450ml', 'Kopi Sachet 1 Renceng', 'Susu UHT 250ml',
            'Jus Jeruk 300ml', 'Minuman Berenergi 150ml', 'Soda Lemon 330ml', 'Yakult 5 Botol',
            'Air Kelapa 330ml', 'Minuman Isotonik 500ml',
        ],
        'Snack' => [
            'Keripik Singkong Pedas', 'Wafer Coklat', 'Biskuit Susu', 'Permen Mint Roll',
            'Chiki Balls BBQ', 'Coklat Batang 40gr', 'Kacang Goreng 200gr', 'Potato Chips 68gr',
            'Makaroni Pedas', 'Stick Keju',
        ],
        'Kebutuhan Rumah' => [
            'Sabun Mandi Batang', 'Shampo Sachet', 'Detergen Bubuk 1kg', 'Sabun Cuci Piring',
            'Tisu Gulung 12 Roll', 'Pembalut Wanita', 'Odol Putih 120gr', 'Deodoran Roll On',
        ],
        'Peralatan' => [
            'Baterai AA 4 Buah', 'Lampu LED 10W', 'Korek Api Gas', 'Kantong Plastik 1 Pack',
            'Lilin 10 Batang', 'Spidol Permanent',
        ],
        'Lainnya' => [
            'Pulsa Fisik 10rb', 'Kartu Perdana', 'Stamp Pos', 'Amplop 10 Buah',
        ],
    ];

    public function definition(): array
    {
        $category = $this->faker->randomElement(Product::CATEGORIES);

        $names = $this->productsByCategory[$category] ?? [];
        $name = !empty($names)
            ? $this->faker->randomElement($names)
            : $this->faker->words(3, true);

        $price = match($category) {
            'Makanan'          => $this->faker->numberBetween(3000, 75000),
            'Minuman'          => $this->faker->numberBetween(2000, 25000),
            'Snack'            => $this->faker->numberBetween(2000, 20000),
            'Kebutuhan Rumah'  => $this->faker->numberBetween(3000, 50000),
            'Peralatan'        => $this->faker->numberBetween(5000, 150000),
            default            => $this->faker->numberBetween(1000, 50000),
        };

        $costPrice = round($price * $this->faker->randomFloat(2, 0.70, 0.85), -2);

        return [
            'name'        => $name,
            'sku'         => strtoupper($this->faker->bothify('??-####')), 
            'description' => $this->faker->optional(0.7)->sentence(10),  
            'category'    => $category,
            'price'       => $price,
            'cost_price'  => $costPrice,
            'stock'       => $this->faker->numberBetween(5, 200),
            'unit'        => $this->faker->randomElement(['pcs', 'kg', 'liter', 'pak', 'dus']),
            'is_active'   => $this->faker->boolean(90), 
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn() => ['stock' => 0]);
    }

    public function lowStock(): static
    {
        return $this->state(fn() => [
            'stock' => $this->faker->numberBetween(1, 10),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn() => ['is_active' => false]);
    }
}