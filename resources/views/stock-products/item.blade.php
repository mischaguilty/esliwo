<div>
    <div class="d-inline-flex p-3 w-100 justify-content-between align-items-center">
        <a href="{{ route('stock-products.show', ['stockProduct' => $this->stockProduct]) }}"
           class="text-decoration-none">
            <div class="flex-grow-1 d-inline-flex">
                <div class="flex-shrink-1">
                    <i class="fa fa-home {{ $stockProduct->prices_count ? 'text-success' : 'text-secondary' }}"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="text-dark">
                        {{ $stock->name }}
                    </div>
                </div>
            </div>
        </a>
        <div class="flex-shrink-1">
            @if($actual_quantity)
                <strong class="text-primary">{{ $actual_quantity?->quantity }}</strong>
            @else
                <a type="button" class="btn btn-link text-decoration-none" wire:loading.class="disabled"
                   wire:click="getStockProductInfo">
                    <div class="spinner-border visually-hidden" role="status"
                         wire:loading
                         wire:loading.class.remove="visually-hidden"
                         wire:target="getStockProductInfo">
                    </div>
                    <i class="fa fa-2x fa-sync" wire:loading.class="visually-hidden"></i>
                </a>
            @endif
        </div>
    </div>
</div>
