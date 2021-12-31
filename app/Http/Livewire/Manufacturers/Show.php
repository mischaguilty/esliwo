<?php

namespace App\Http\Livewire\Manufacturers;

use App\Http\Traits\WithPlacement;
use App\Models\Manufacturer;
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
    use WithPlacement;

    public string $search = '';
    protected $listeners = ['$refresh'];

    public Manufacturer $manufacturer;

    public function route(): \Illuminate\Routing\Route
    {
        return Route::get('/manufacturers/{manufacturer}', static::class)
            ->name('manufacturers.show')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('manufacturers.show')->with([
            'products' => $this->queryPlacement()->paginate(),
        ]);
    }

    public function query(): Builder
    {
        return $this->manufacturer->products()->getQuery()
            ->when(!empty($this->search), function (Builder $builder) {
                $builder->orWhere('elsie_code', 'like', $this->search . '%')
                    ->orWhere('name', 'like', "%" . $this->search . "%");
            });
    }
}
