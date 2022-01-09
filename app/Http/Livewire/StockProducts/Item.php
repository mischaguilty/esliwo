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
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Item extends Component
{
    public StockProduct $stockProduct;
    public int $quantity = -1;

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct->loadCount('prices', 'quantities');
        $this->quantity = optional($this->stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
                return $quantity->quantity;
            }) ?? $this->quantity;
    }

    public function stockProductUpdated()
    {
        $this->emitUp('$refresh');
    }

    public function render(): Factory|View|Application
    {
        if ($this->quantity >= 0) {
            dispatch(new GetStockProductInfoJob($this->stockProduct))->onQueue('default')->afterResponse();
        }

        return view('stock-products.item')->with([
            'stock' => optional($this->stockProduct->stock()->first() ?? null, function (Stock $stock) {
                return $stock;
            }),
            'product' => optional($this->stockProduct->product()->first() ?? null, function (Product $product) {
                return $product;
            }),
            'actual_price' => $this->stockProduct->actual_price,
            'actual_quantity' => $this->stockProduct->actual_quantity,
            'prev_quantity' => optional($this->stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
                return optional($this->stockProduct->quantities()->latest()
                        ->where(function (Builder $builder) use ($quantity) {
                            $builder
                                ->where('id', '<', $quantity->id)
                                ->where('quantity', '<>', $quantity->quantity);
                        })->first() ?? null, function (StockProductQuantity $quantity) {
                    return $quantity;
                });
            }),
        ]);
    }
}
