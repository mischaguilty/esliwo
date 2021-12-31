<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Home extends Component
{
    public function route(): \Illuminate\Routing\Route|array
    {
        return Route::get('/home', static::class)
            ->middleware('auth')
            ->name('home');
    }

    public function render(): Factory|View|Application
    {
        return view('home');
    }
}
