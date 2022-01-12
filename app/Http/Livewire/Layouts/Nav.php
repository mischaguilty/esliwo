<?php

namespace App\Http\Livewire\Layouts;

use App\Actions\ElsieServiceStateAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Redirector;

class Nav extends Component
{
    protected $listeners = ['$refresh'];

    public function render()
    {
        return view('layouts.nav');
    }

    public function logout(): Redirector
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
