<?php

namespace App\Http\Livewire\Layouts;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Redirector;

class Nav extends Component
{
    protected $listeners = ['$refresh'];

    public function render(): Factory|View|Application
    {
        return view('layouts.nav');
    }

    public function logout(): RedirectResponse|Redirector
    {
        Auth::logout();

        return redirect()->to('/');
    }
}
