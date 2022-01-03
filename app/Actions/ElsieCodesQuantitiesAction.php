<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieCodesQuantitiesAction
{
    use AsAction;

    public function handle(array $codes): Collection
    {
        ElsieTrashAction::make()->handle($codes, true);
        $trash = ElsieShowTrashAction::make()->handle();
        ElsieTrashAction::make()->handle($codes);
        return $this->parseTrash($trash, $codes);
    }

    protected function parseTrash(array $trash, array $codes): Collection
    {
        return collect($trash)->map(function (array $item) use ($codes) {

            $trashCode = isset($item[0]) && isset($item[7]) ? implode('_', [
                $item[0], $item[7],
            ]) : null;

            if (in_array($trashCode, $codes)) {
                $pData = collect([
                    'stock' => $item[7] ?? null,
                    'elsie_code' => $item[0] ?? null,
                    'stock_code' => $item[1] ?? null,
                    'size' => implode('x', [
                        $item[8] ?? '',
                        $item[9] ?? '',
                    ]),
                    'price' => $item[3] ?? null,
                    'quantity' => $item[5] ?? ($item[6] ?? 0),
                ]);

                $stock = optional(Stock::query()->firstWhere([
                        'shop_id' => $pData['stock'],
                    ]) ?? null, function (Stock $stock) {
                    return $stock;
                });

                $product = optional(Product::query()->firstWhere([
                        'elsie_code' => $pData['elsie_code'],
                    ]) ?? null, function (Product $product) {
                    return $product;
                });

                if (is_a($stock, Stock::class) && is_a($product, Product::class)) {
                    return optional(StockProduct::query()->firstOrCreate([
                            'stock_id' => $stock->id,
                            'product_id' => $product->id,
                        ]) ?? null, function (StockProduct $stockProduct) use ($pData) {

                        $stockProduct->prices()->create([
                            'price' => $pData['price'],
                        ])->touchOwners();

                        $stockProduct->quantities()->create([
                            'quantity' => $pData['quantity'],
                        ])->touchOwners();
                    });
                }
            }
            return null;
        })->filter(function ($item) {
            return !empty($item);
        });
    }

}
