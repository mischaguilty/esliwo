<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Welcome extends Component
{
    public function route(): \Illuminate\Routing\Route
    {
        return
            Route::get('/', static::class)
                ->name('welcome');
    }

    public function render(): Factory|View|Application
    {
        return view('welcome');
    }
}
