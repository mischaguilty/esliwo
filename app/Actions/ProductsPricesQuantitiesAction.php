<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Lorisleiva\Actions\Concerns\AsAction;

class ProductsPricesQuantitiesAction
{
    use AsAction;

    public Product $product;

    public function handle(Product $product)
    {
        $this->product = $product;

        $codes = Stock::query()->get()->map(function (Stock $stock) {
            return optional(StockProduct::query()->firstOrCreate([
                    'stock_id' => $stock->id,
                    'product_id' => $this->product->id,
                ]) ?? null, function (StockProduct $stockProduct) {
                return $stockProduct->trash_code;
            });
        })->toArray();

        ElsieTrashAction::make()->handle($codes, true);
        $trash = ElsieShowTrashAction::make()->handle();
        ElsieTrashAction::make()->handle($codes);
        return !empty($trash);
    }
}
