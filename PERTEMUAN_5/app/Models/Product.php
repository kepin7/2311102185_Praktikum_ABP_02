<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string|null $description
 * @property string $category
 * @property float $price
 * @property float|null $cost_price
 * @property int $stock
 * @property string $unit
 * @property string|null $image
 * @property bool $is_active
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'price',
        'cost_price',
        'stock',
        'unit',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock'      => 'integer',
        'is_active'  => 'boolean',
    ];

    public const CATEGORIES = [
        'Makanan',
        'Minuman',
        'Snack',
        'Kebutuhan Rumah',
        'Peralatan',
        'Lainnya',
    ];

    public const UNITS = [
        'pcs', 'kg', 'gram', 'liter', 'ml', 'lusin', 'pak', 'dus',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeLowStock($query, int $threshold = 10)
    {
        return $query->where('stock', '<=', $threshold);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock === 0) return 'Habis';
        if ($this->stock <= 10) return 'Menipis';
        return 'Tersedia';
    }

    public function getStockBadgeColorAttribute(): string
    {
        return match($this->stock_status) {
            'Habis'   => 'red',
            'Menipis' => 'yellow',
            default   => 'green',
        };
    }
}