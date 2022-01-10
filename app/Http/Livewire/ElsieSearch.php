<?php

namespace App\Http\Livewire;

use App\Actions\Data\ElsieSearchAction;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

class ElsieSearch extends Component
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
        return Route::get('/search', static::class)
            ->name('search')
            ->middleware('auth');
    }

    public function render()
    {
        return view('elsie-search')->with([
            'products' => $this->query()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        optional(ElsieSearchAction::make()->handle($this->search) ?? null, function (array $items) {
            collect($items)->filter(function ($item) {
                return !empty($item);
            })->each(function (array $item) {
                optional($item[2] ?? null, function (string $name) use ($item) {
                    optional(Product::query()->firstOrCreate([
                            'elsie_code' => $item[0] ?? null,
                            'stock_code' => $item[1] ?? null,
                            'width' => $item[6] ?? null,
                            'height' => $item[7] ?? null,
//                            'name' => $name . ' ' . $item[8] ?? '',
                        ]) ?? null, function (Product $product) {
                        dd($product->suggestedManufacturer());
                    });
                });
            });
        });

        return Product::query()->when(!empty($this->search), function (Builder $builder) {
            return $builder->where('name', 'like', "%" . $this->search . "%");
        });
    }
}

