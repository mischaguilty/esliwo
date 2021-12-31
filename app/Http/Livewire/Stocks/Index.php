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

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sort = 'Name';
    public array $sorts = ['Name', 'Newest', 'Oldest'];
    public string $filter = 'All';
    public array $filters = ['All', 'Custom'];

    protected $listeners = ['$refresh'];

    public function route(): \Illuminate\Routing\Route
    {
        return Route::get('/stocks', static::class)
            ->name('stocks')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('stocks.index', [
            'stocks' => $this->query()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        $query = Stock::query()->when($this->search, function (Builder $query) {
            return $query->orWhere('name', 'like', '%' . $this->search . '%');
        })->whereNotNull('shop_id');

//        switch ($this->sort) {
//            case 'Name': $query->orderBy('name'); break;
//            case 'Newest': $query->orderByDesc('created_at'); break;
//            case 'Oldest': $query->orderBy('created_at'); break;
//        }
//
//        switch ($this->filter) {
//            case 'All': break;
//            case 'Custom': $query->whereNull('created_at'); break;
//        }

        return $query->orderBy('shop_id');
    }

    public function delete(Stock $stock)
    {
        $stock->delete();
    }
}
