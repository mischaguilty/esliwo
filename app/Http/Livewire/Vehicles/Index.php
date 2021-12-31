<?php

namespace App\Http\Livewire\Vehicles;

use App\Models\Vehicle;
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

    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/vehicles', static::class)
            ->name('vehicles')
            ->middleware('auth');
    }

    public function render(): Factory|View|Application
    {
        return view('vehicles.index', [
            'vehicles' => $this->query()->paginate(),
        ]);
    }

    public function query(): Builder
    {
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
//
        return Vehicle::query()->when($this->search, function (Builder $query) {
            return $query->where(function (Builder $query) {
                $query->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', $this->search . '%');
            });
        })
            ->whereHas('products')
            ->withCount('products')
//            ->orderBy('name')
//            ->orderBy('year_start')
            ->orderByDesc('products_count');
    }

    public function delete(Vehicle $vehicle)
    {
        $vehicle->delete();
    }
}
