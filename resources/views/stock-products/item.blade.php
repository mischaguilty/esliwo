<div>
    @isset($stockProduct)
        <a href="{{ route('stock-products.show', ['stockProduct' => $stockProduct]) }}" class="text-decoration-none">
            @endisset
            <div class="d-flex align-items-center">
                {{--            <div class="flex-shrink-0">--}}
                {{--                <i class="fa fa-2x {{ $presented ? 'fa-store' : 'fa-store-slash' }} {{ $presented ? 'text-success' : 'text-secondary' }}"></i>--}}
                {{--            </div>--}}
                <div class="flex-grow-1 ms-3">
                    <div class="text-dark">
                        {{ $stock->name }}
                    </div>
                </div>
            </div>
        @isset($stockProduct)
            {{--    </a>--}}
        @endisset
</div>