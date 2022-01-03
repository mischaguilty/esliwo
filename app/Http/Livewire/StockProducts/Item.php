<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Item extends Component
{
    public StockProduct $stockProduct;
    public ?Stock $stock;
    public ?Product $product;

    public function mount(StockProduct $stockProduct = null, Stock $stock = null, Product $product = null)
    {
        if (!$stockProduct->exists) {
            $stock = optional($stock->exists ? $stock->loadMissing('products') : null, function (Stock $stock) {
                    return $stock;
                }) ?? new Stock;
            if (!$stock->exists) {
                return;
            }

            $product = optional($product->exists ? $product->loadMissing('stocks') : null, function (Product $product) {
                    return $product;
                }) ?? new Product;

            if (!$product->exists) {
                return;
            }

            $stockProduct = optional(StockProduct::query()->firstOrCreate([
                        'stock_id' => $stock->id,
                        'product_id' => $product->id,
                    ]) ?? null, function (StockProduct $stockProduct) {
                    return $stockProduct->loadMissing([
                        'prices', 'quantities'
                    ]);
                }) ?? new StockProduct;
        }

        $this->stockProduct = $stockProduct;
    }

    public function render(): Factory|View|Application
    {
        return view('stock-products.item');
    }
}
