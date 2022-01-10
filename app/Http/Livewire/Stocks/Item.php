<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Item extends Component
{
    public Stock $stock;
    public ?StockProduct $stockProduct;

    public function mount(Stock $stock, Product $product = null)
    {
        $this->stock = $stock->loadMissing('products');
        $this->sProduct = $product ? optional($product->exists ? $product : null, function (Product $product) {
            return StockProduct::query()->firstOrCreate([
                'stock_id' => $this->stock->id,
                'product_id' => $product->id,
            ]);
        }) : null;
    }

    public function render()
    {
        return view('stocks.item');
    }
}
