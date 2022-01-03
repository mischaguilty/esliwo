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
    public Stock $stock;
    public Product $product;
    public ?StockProduct $stockProduct;

    public function mount(Stock $stock, Product $product, StockProduct $stockProduct = null)
    {
        $this->stock = $stock;
        $this->product = $product;

        $this->stockProduct = optional($stockProduct ?? StockProduct::query()->firstOrCreate([
                'stock_id' => $this->stock->id,
                'product_id' => $this->product->id,
            ]), function (StockProduct $stockProduct) {
            return $stockProduct;
        });
    }

    protected $listeners = [
        '$refresh',
    ];

    public function render(): Factory|View|Application
    {
        return view('stock-products.item')->with([

        ]);
    }

    public function getStockProductInfo()
    {

        $this->emit('$refresh');
    }
}
