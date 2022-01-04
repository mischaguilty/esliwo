<?php

namespace App\Http\Livewire\Stocks;

use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Stock $stock;

    public function route(): \Illuminate\Routing\Route
    {
        return Route::get('/stocks/{stock}', static::class)
            ->name('stocks.show')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('stocks.show')->with([
            'products' => $this->query()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        return $this->stock->products()->getQuery();
    }
}
