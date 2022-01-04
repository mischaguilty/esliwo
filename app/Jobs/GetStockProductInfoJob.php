<?php

namespace App\Jobs;

use App\Actions\StockProductInfoAction;
use App\Events\StockProductUpdatedEvent;
use App\Models\StockProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetStockProductInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private StockProduct $stockProduct;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(StockProductInfoAction $action)
    {
        $action->handle($this->stockProduct);
        event(new StockProductUpdatedEvent($this->stockProduct->refresh()));
    }
}
