<div>
    <a href="{{ route('stock-products.show', ['stockProduct' => $this->stockProduct]) }}" class="text-decoration-none">
        <div class="flex-shrink-1">
            @php($class = $stockProduct ? ($stockProduct->prices()->count() ? 'text-success' : 'text-secondary') : 'text-secondary')
            <i class="fa fa-home {{ $class }}"></i>
        </div>
        <div class="flex-grow-1 ms-3">
            <div class="text-dark">
                {{ $stock->name }}
            </div>
        </div>
    </a>
</div>
