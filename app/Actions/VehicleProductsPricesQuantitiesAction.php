<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\Vehicle;
use Lorisleiva\Actions\Concerns\AsAction;

class VehicleProductsPricesQuantitiesAction
{
    use AsAction;

    public Vehicle $vehicle;

    public function handle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

        Stock::query()->get()->map(function (Stock $stock) {
            $codes = $this->vehicle->products()->get()->toBase()->map(function (Product $product) use ($stock) {
                return optional(StockProduct::query()->firstOrCreate([
                        'stock_id' => $stock->id,
                        'product_id' => $product->id,
                    ]) ?? null, function (StockProduct $stockProduct) {
                    return $stockProduct->trash_code;
                });
            })->toArray();


            ElsieTrashAction::make()->handle($codes, true);
            $trash = ElsieShowTrashAction::make()->handle();
            ElsieTrashAction::make()->handle($codes);

            $trash = collect($trash);
            $trash = $trash->except($trash->keys()->last());

            dd($trash);

            collect($trash)->each(function (array $item) use ($stock) {
                optional(Product::query()->firstWhere('elsie_code', '=', $item[0]) ?? null, function (Product $product) use ($stock) {
                    $product->update([
                        'search_name' => $item[2] ?? null,
                        'note' => $item[10] ?? null,
                    ]);

                    optional(StockProduct::query()->firstOrCreate([
                            'stock_id' => $stock->id,
                            'product_id' => $product->id,
                        ]) ?? null, function (StockProduct $stockProduct) use ($item) {
                        $stockProduct->prices()->create([
                            'price' => $item[3] ?? null,
                        ]);
                        $stockProduct->quantities()->create([
                            'quantity' => $item[5] ?? ($item[6] ?? null),
                        ]);
                    });
                });
            });
        });
    }
}
