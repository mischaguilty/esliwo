<?php

namespace App\Http\Livewire\StockProducts;

use App\Jobs\GetStockProductInfoJob;
use App\Models\StockProduct;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Show extends Component
{
    public StockProduct $stockProduct;
    public array $lineChartData;

    public function mount(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
        $this->lineChartData = optional($this->stockProduct->prices()->get()->toArray() ?? [], function (array $prices) {
            return $prices;
        });
    }

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/stock-products/{stockProduct}', static::class)
            ->name('stock-products.show')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        $this->stockProduct->loadMissing([
            'stock', 'product', 'prices', 'quantities',
        ]);
        return view('stock-products.show');
    }

    public function getStockInfo()
    {
        $this->lineChartData = LivewireCharts::lineChartModel()
            ->setTitle($this->stockProduct->product->name . ' ' . __('prices'))->markers->toArray();

        dispatch(new GetStockProductInfoJob($this->stockProduct))->onQueue('default')->afterResponse();
        $this->emit('$refresh');
    }
}
