<?php

namespace App\Actions;

use App\Models\StockProduct;
use Lorisleiva\Actions\Concerns\AsAction;

class StockProductInfoAction
{
    use AsAction;

    public function handle(StockProduct $stockProduct)
    {
        return optional($stockProduct->trash_code ?? null, function (string $code) {
            return ElsieCodesQuantitiesAction::make()->handle([$code]);
        });
    }
}