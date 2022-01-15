<?php

namespace App\Http\Livewire;

use App\Models\ElsieCredentials;
use Livewire\Component;

class ElsieSearch extends Component
{
    public ElsieCredentials $elsieCredentials;

    public string $codeSearch;
    public string $nameSearch;

    public function mount(ElsieCredentials $elsieCredentials = null, string $codeSearch = '', string $nameSearch = '')
    {
        $this->elsieCredentials = $elsieCredentials ?? auth()->user()->elsie_credentials()->first();
        $this->codeSearch = $codeSearch ?? request()->query('code', '');
        $this->nameSearch = $nameSearch ?? request()->query('name', '');
    }

    public function render()
    {
        return view('elsie-search');
    }
}
