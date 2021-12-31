<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Show extends Component
{
    public Stock $stock;

    public function route(): \Illuminate\Routing\Route
    {
        return Route::get('/stocks/{stock}/show', static::class)
            ->name('stocks.show')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('stocks.show');
    }
}
