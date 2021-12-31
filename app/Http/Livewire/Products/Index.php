<?php

namespace App\Http\Livewire\Products;

use App\Http\Traits\WithPlacement;
use App\Models\Product;
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
    use WithPlacement;

    public string $search = '';
    public string $sort = 'Name';
    public array $sorts = ['Name', 'Newest', 'Oldest'];
    public string $filter = 'All';
    public array $filters = ['All', 'Custom'];

    protected $listeners = ['$refresh'];

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/products', static::class)
            ->name('products')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('products.index', [
            'products' => $this->queryPlacement()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        return Product::query()
            ->glasses()
            ->when($this->search, function (Builder $builder) {
                return $builder->where(function (Builder $builder) {
                    $builder->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('elsie_code', 'like', $this->search . "%");
                });
            })
            ->whereHas('stock_products.prices')
            ->whereHas('stock_products.quantities')
            ->orderBy('elsie_code');

//
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
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
