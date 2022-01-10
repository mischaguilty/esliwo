<?php

namespace App\Events;

use App\Models\StockProduct;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockProductUpdatedEvent implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets, Dispatchable;

    private StockProduct $stockProduct;

    public function getStockProduct(): StockProduct
    {
        return $this->stockProduct;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel($this->getChannelName());
    }

    protected function getChannelName(): string
    {
        return implode('.', [
            'stock-products',
            $this->stockProduct->id,
        ]);
    }
}
