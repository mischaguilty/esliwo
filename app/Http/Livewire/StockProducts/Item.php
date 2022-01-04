<?php

namespace App\Http\Livewire\StockProducts;

use App\Jobs\GetStockProductInfoJob;
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
    
    public function render(): Factory|View|Application
    {
        return view('stock-products.item')->with([
            'stock' => optional($this->stockProduct->stock()->first() ?? null, function (Stock $stock) {
                return $stock;
            }),
            'product' => optional($this->stockProduct->product()->first() ?? null, function (Product $product) {
                return $product;
            }),
            'actual_price' => $this->stockProduct->actual_price,
            'actual_quantity' => $this->stockProduct->actual_quantity,
        ]);
    }

    public function getStockProductInfo()
    {
        dispatch(new GetStockProductInfoJob($this->stockProduct))->onQueue('default')->afterResponse();
        $this->emit('$refresh');
    }
}
