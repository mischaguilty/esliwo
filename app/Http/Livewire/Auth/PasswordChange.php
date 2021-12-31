<?php

namespace App\Http\Livewire\Auth;

use Bastinald\Ui\Traits\WithModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PasswordChange extends Component
{
    use WithModel;

    public function render(): Factory|View|Application
    {
        return view('auth.password-change');
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'password'],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function save()
    {
        $this->validateModel();

        Auth::user()->update($this->getModel(['password']));

        $this->emit('hideModal');
    }
}
