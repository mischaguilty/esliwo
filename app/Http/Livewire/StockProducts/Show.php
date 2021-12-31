<?php

namespace App\Http\Livewire\StockProducts;

use App\Models\StockProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Show extends Component
{
    public StockProduct $sProduct;

    public function mount(StockProduct $sProduct)
    {
        $this->sProduct = $sProduct;
    }

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/stock-products/{sProduct}', static::class)
            ->name('stock-products.show')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        $this->sProduct->loadMissing([
            'stock', 'product',
        ])->fresh([
            'prices', 'quantities',
        ]);

        return view('stock-products.show');
    }
}
