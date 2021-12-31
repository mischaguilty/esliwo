<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Show extends Component
{
    public Product $product;

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/products/{product}', static::class)
            ->name('products.show')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('products.show');
    }
}
