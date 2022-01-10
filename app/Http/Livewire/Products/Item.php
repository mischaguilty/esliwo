<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Item extends Component
{
    public Product $product;

    public function render()
    {
        return view('products.item');
    }
}
