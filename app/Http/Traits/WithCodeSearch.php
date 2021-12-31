<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithCodeSearch
{
    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
        $this->emit('$refresh');
    }

    public function queryCodeSearch(Builder $builder)
    {
        return $builder->when(!empty($this->search), function (Builder $builder) {
            $builder->where('elsie_code', 'like', $this->search . '%');
        });
    }


}