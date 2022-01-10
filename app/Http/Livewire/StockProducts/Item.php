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
//        'echo:sproducts,ProductQuantityUpdated' => 'stockProductUpdated',
        'stockProductUpdated'
    ];

    public function mount(StockProduct $stockProduct)
    {
        Log::info('Mount ' . $stockProduct->id);

        $this->stockProduct = $stockProduct->loadCount('prices', 'quantities')->load('quantities', 'prices');
        $this->quantity = optional($this->stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
                return $quantity->quantity;
            }) ?? -1;
    }

    public function stockProductUpdated($stockProductId)
    {
        if ($this->stockProduct->id === $stockProductId) {
            Log::info($this->stockProduct->toJson());

            $this->quantity = optional($this->stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
                    return $quantity->quantity;
                }) ?? $this->stockProduct->quantities()->create([
                    'quantity' => 0,
                ])->quantity;
            $this->emit('$refresh');
        }
    }

    public function getStockProductInfo(StockProduct $stockProduct)
    {
        if ($stockProduct->id === $this->stockProduct->id) {
            GetStockProductInfoJob::dispatch($stockProduct);
        }
    }

    public function render(): Factory|View|Application
    {
        if ($actualQuantity = $this->stockProduct->actual_quantity) {
        } else {
            dispatch(new GetStockProductInfoJob($this->stockProduct))->afterResponse();
        }

        return view('stock-products.item')->with([
            'stock' => optional($this->stockProduct->stock()->first() ?? null, function (Stock $stock) {
                return $stock;
            }),
            'product' => optional($this->stockProduct->product()->first() ?? null, function (Product $product) {
                return $product;
            }),
            'actual_price' => $this->stockProduct->actual_price,
            'actual_quantity' => $actualQuantity ?? $this->stockProduct->quantities()->create([
                    'quantity' => 0,
                ]),
//            'prev_quantity' => optional($this->stockProduct->actual_quantity ?? null, function (StockProductQuantity $quantity) {
//                return optional($this->stockProduct->quantities()->latest()
//                        ->where(function (Builder $builder) use ($quantity) {
//                            $builder
//                                ->where('id', '<', $quantity->id)
//                                ->where('quantity', '<>', $quantity->quantity);
//                        })->first() ?? null, function (StockProductQuantity $quantity) {
//                    return $quantity;
//                });
//            }),
        ]);
    }
}
