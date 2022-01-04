<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Stock;

class ProductsObserver
{
    public function afterCommitCreated(Product $product)
    {
        $product->stocks()->saveMany(Stock::all()->toArray());
    }
}
