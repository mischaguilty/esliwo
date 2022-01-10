<?php

namespace App\Actions\Data;

use App\Models\StockProduct;
use Lorisleiva\Actions\Concerns\AsAction;

class StockProductInfoAction
{
    use AsAction;

    //Using for One StockProduct object
    public function handle(StockProduct $stockProduct)
    {
        return optional($stockProduct->trash_code ?? null, function (string $code) {
            return ElsieCodesQuantitiesAction::make()->handle([$code]);
        });
    }
}