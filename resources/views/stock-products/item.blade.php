<div name="stockProduct_{{ $stockProduct->id }}">
    <div class="d-inline-flex p-3 w-100 justify-content-between align-items-center">
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
        <div class="flex-shrink-1">
            @if($quantity >= 0)
                <strong class="text-primary">{{ $quantity }}</strong>
            @else
                <div class="spinner-border text-secondary" role="status"></div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Echo.channel('events').listen('StockProductUpdatedEvent', function (e) {
            console.log(e);
        });
    </script>
@endpush
