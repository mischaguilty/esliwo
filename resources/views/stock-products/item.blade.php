<div name="stockProduct_{{ $stockProduct->id }}">
    <div class="d-inline-flex p-3 w-100 justify-content-between align-items-center">
        <div class="flex-grow-1">
            <a href="{{ route('stock-products.show', ['stockProduct' => $stockProduct]) }}"
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
        </div>
        <div class="d-inline-flex flex-nowrap">
            @if(is_a($actual_quantity, \App\Models\StockProductQuantity::class))
                <div class="d-block">
                    <div class="text-primary">{{ $actual_quantity->quantity }} -
                        @if($prev_quantity = $prev_quantity ?? $actual_quantity)
                            <span class="text-secondary">({{ $prev_quantity->quantity}}
                        , {{ $prev_quantity->created_at->shortRelativeToNowDiffForHumans() }})
                        </span>
                        @endif
                    </div>
                    <div class="fw-lighter">
                        {{ $actual_quantity->created_at->shortRelativeToNowDiffForHumans() }}
                    </div>
                </div>
            @else
                <div class="spinner-border text-secondary" role="status"></div>
            @endif
        </div>
    </div>
</div>
