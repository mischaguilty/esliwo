<?php

namespace App\Http\Livewire\StockProducts;

use App\Jobs\GetStockProductInfoJob;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\StockProductQuantity;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Item extends Component
{
    public StockProduct $stockProduct;
    public int $quantity = -1;

    protected $listeners = [
        'postAdded' => 'stockProductUpdated',
    ];

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
        $this->quantity = optional($this->stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
                return $quantity->quantity;
            }) ?? $this->quantity;
    }

    public function stockProductUpdated(StockProduct $stockProduct)
    {
        Log::info(json_encode($stockProduct));;

//        if ($this->stockProduct->id === $stockProduct->id) {
        $this->quantity = optional($stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
                return $quantity->quantity;
            }) ?? $this->quantity;
        $this->emit('$refresh');
//        }
    }

    public function render(): Factory|View|Application
    {
        dispatch(new GetStockProductInfoJob($this->stockProduct))->onQueue('default')->afterResponse();

        return view('stock-products.item')->with([
            'stock' => optional($this->stockProduct->stock()->first() ?? null, function (Stock $stock) {
                return $stock;
            }),
            'product' => optional($this->stockProduct->product()->first() ?? null, function (Product $product) {
                return $product;
            }),
            'actual_price' => $this->stockProduct->actual_price,
        ]);
    }
}
