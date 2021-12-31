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
                    'width' => $item[8] ?? null,
                    'height' => $item[9] ?? null,
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
                        'width' => $pData['width'],
                        'height' => $pData['height'],
                    ]) ?? null, function (Product $product) {
                    return $product;
                });

                if (is_a($stock, Stock::class) && is_a($product, Product::class)) {
                    return optional(StockProduct::query()->firstOrCreate([
                            'stock_id' => $stock->id,
                            'product_id' => $product->id,
                        ]) ?? null, function (StockProduct $stockProduct) use ($pData) {
                        dump($pData['elsie_code'], $pData['stock']);

                        return $stockProduct->quantities()->create([
                            'quantity' => $pData['quantity'],
                        ]);
                    });
                }
            }
            return null;
        })->filter(function ($item) {
            return !empty($item);
        });
    }

}
