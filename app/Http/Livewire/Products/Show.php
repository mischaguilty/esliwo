<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\StockProductPrice;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Product $product;

    protected $listeners = [
        '$refresh',
    ];

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/products/{product}', static::class)
            ->name('products.show')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('products.show')->with([
            'stockProducts' => Stock::query()->get()->toBase()->map(function (Stock $stock) {
                return optional(StockProduct::query()->firstOrCreate([
                        'stock_id' => $stock->id,
                        'product_id' => $this->product->id,
                    ]) ?? null, function (StockProduct $stockProduct) {
                    return $stockProduct->fresh([
                        'prices', 'quantities',
                    ]);
                });
            })->sortByDesc(function (StockProduct $stockProduct) {
                return $stockProduct->actual_quantity?->quantity;
            }),
            'actual_price' => optional($this->product->prices()->latest()->first() ?? null, function (StockProductPrice $price) {
                return implode(' ', [$price->price, $price->currency]);
            }),
        ]);
    }
}
