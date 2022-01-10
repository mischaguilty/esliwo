<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Kirschbaum\PowerJoins\PowerJoins;

class StockProduct extends Pivot
{
    use HasFactory;
    use PowerJoins;

    protected $table = 'stock_products';

    public $incrementing = true;

    protected $fillable = [
        'stock_id',
        'product_id',
    ];

    public static function findByTrashCode(string $trashCode): ?StockProduct
    {
        $trashCode = collect(explode('_', $trashCode));
        if ($trashCode->count() === 2) {
            $product = optional($trashCode->first() ?? null, function (string $productCode) {
                return Product::query()->firstWhere([
                    'elsie_code' => $productCode,
                ]);
            });
            $stock = optional($trashCode->last() ?? null, function (string $stockCode) {
                return Stock::query()->firstWhere([
                    'shop_id' => $stockCode,
                ]);
            });

            if (is_a($stock, Stock::class) && is_a($product, Product::class)) {
                return optional(StockProduct::query()->firstWhere([
                        'stock_id' => $stock->id,
                        'product_id' => $product->id,
                    ]) ?? null, function (StockProduct $stockProduct) {
                    return $stockProduct;
                });
            }
        }
        return null;
    }

    public function getTrashCodeAttribute(): ?string
    {
        $stock = optional($this->stock()->first() ?? null, function (Stock $stock) {
            return $stock->shop_id;
        });

        $product = optional($this->product()->first() ?? null, function (Product $product) {
            return $product->elsie_code;
        });

        return !empty($stock) && !empty($product) ? implode('_', [
            $product, $stock,
        ]) : null;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(StockProductPrice::class, 'stock_product_id', 'id');
    }

    public function getActualPriceAttribute(): ?StockProductPrice
    {
        return optional($this->prices()->latest()->first() ?? null, function (StockProductPrice $price) {
            return $price;
        });
    }

    public function quantities(): HasMany
    {
        return $this->hasMany(StockProductQuantity::class, 'stock_product_id', 'id');
    }

    public function getActualQuantityAttribute(): ?StockProductQuantity
    {
        return optional($this->quantities()->latest()->first() ?? null, function (StockProductQuantity $quantity) {
            return $quantity;
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return self::query()->find($value);
    }
}
