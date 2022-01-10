<?php

namespace App\Events;

use App\Models\StockProduct;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductQuantityUpdated implements ShouldBroadcast
{
    use InteractsWithBroadcasting;
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public StockProduct $stockProduct;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(StockProduct $stockProduct)
    {
        $this->stockProduct = $stockProduct;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel|array
     */
    public function broadcastOn()
    {
        return new Channel('sproducts');
    }
}
