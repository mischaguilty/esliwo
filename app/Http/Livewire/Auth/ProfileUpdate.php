<?php

namespace App\Http\Livewire\Auth;

use Bastinald\Ui\Traits\WithModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProfileUpdate extends Component
{
    use WithModel;

    public function mount()
    {
        $this->setModel(Auth::user()->toArray());
    }

    public function render(): Factory|View|Application
    {
        return view('auth.profile-update');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
        ];
    }

    public function save()
    {
        $this->validateModel();

        Auth::user()->update($this->getModel());

        $this->emit('hideModal');
        $this->emit('$refresh');
    }
}
