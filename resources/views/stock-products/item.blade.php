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
            @if($quantity >= 0)
                <div class="d-block text-center">
                    <div class="text-primary">
                        {{ $actual_quantity->quantity }}
                    </div>
                    <div class="fw-lighter">
                        {{ $actual_quantity->created_at->shortRelativeToNowDiffForHumans() }}
                    </div>
                    <button class="btn btn-primary shadow-none"
                            wire:click="getStockProductInfo({{ $stockProduct->id }})">{{ __('Update') }}</button>
                </div>
            @else
                <div class="spinner-border text-secondary" role="status"></div>
            @endif
        </div>
    </div>
</div>

@push('scripts')

    <script>
        {{--window.Echo.channel("stock-product.{{ $stockProduct->id }}").listen('ProductQuantityUpdated', function (e) {--}}
        //     window.livewire.emit('$refresh');
        {{--    window.document.getElementsByName('stockProduct_{{ $stockProduct->id }}').forEach(function (element, index) {--}}
        //         element.classList.add('bg-danger');
        //     });
        // });

        window.Echo.channel("sproducts").listen('ProductQuantityUpdated', function (e) {
            console.log(e.stockProduct.id);
            window.livewire.emit('stockProductUpdated', e.stockProduct.id);
            // window.document.getElementsByName('stockProduct_' + e.stockProduct.id).forEach(function (element, index) {
            //     element.classList.add('bg-danger');
            // });
        });
    </script>
@endpush