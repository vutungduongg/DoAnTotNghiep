<?php

namespace App\Support;

use App\Models\Product;
use App\Models\ProductVariant;

class Cart
{
    private const SESSION_KEY = 'cart.items';

    /**
     * @return array<string, array{product_id:int,variant_id:int|null,name:string,size:string|null,price:string,quantity:int,image_path:string|null}>
     */
    public static function items(): array
    {
        /** @var array $items */
        $items = session()->get(self::SESSION_KEY, []);

        return is_array($items) ? $items : [];
    }

    /** @param array<string, array> $items */
    private static function putItems(array $items): void
    {
        session()->put(self::SESSION_KEY, $items);
    }

    public static function count(): int
    {
        return collect(self::items())->sum('quantity');
    }

    public static function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public static function add(Product $product, ?ProductVariant $variant, int $quantity): void
    {
        $quantity = max(1, (int) $quantity);

        $key = self::key($product->id, $variant?->id);
        $items = self::items();

        $size = $variant?->size;
        $price = (string) (($variant?->price ?? $product->base_price));

        if (isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
        } else {
            $items[$key] = [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name' => $product->name,
                'size' => $size,
                'price' => $price,
                'quantity' => $quantity,
                'image_path' => $product->image_path,
            ];
        }

        self::putItems($items);
    }

    public static function update(string $key, int $quantity): void
    {
        $items = self::items();
        if (!isset($items[$key])) {
            return;
        }

        $quantity = max(0, (int) $quantity);
        if ($quantity === 0) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = $quantity;
        }

        self::putItems($items);
    }

    public static function remove(string $key): void
    {
        $items = self::items();
        unset($items[$key]);
        self::putItems($items);
    }

    /**
     * @param array<string, array{price:string,quantity:int}> $items
     * @return array{subtotal:string,total_qty:int}
     */
    public static function totals(array $items): array
    {
        $subtotalCents = 0;
        $totalQty = 0;

        foreach ($items as $item) {
            $priceCents = self::priceToCents((string) $item['price']);
            $subtotalCents += $priceCents * (int) $item['quantity'];
            $totalQty += (int) $item['quantity'];
        }

        return [
            'subtotal' => self::centsToPrice($subtotalCents),
            'total_qty' => $totalQty,
        ];
    }

    private static function priceToCents(string $price): int
    {
        return (int) round(((float) $price) * 100);
    }

    private static function centsToPrice(int $cents): string
    {
        return number_format($cents / 100, 2, '.', '');
    }

    public static function key(int $productId, ?int $variantId): string
    {
        if ($variantId !== null) {
            return 'p'.$productId.'v'.$variantId;
        }

        return 'p'.$productId;
    }
}
