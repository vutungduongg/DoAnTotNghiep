<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    public const LOW_STOCK_THRESHOLD = 5;

    protected $fillable = [
        'product_id',
        'size',
        'sku',
        'price',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isOutOfStock(): bool
    {
        return (int) $this->stock <= 0;
    }

    public function isLowStock(): bool
    {
        $stock = (int) $this->stock;

        return $stock > 0 && $stock <= self::LOW_STOCK_THRESHOLD;
    }
}
