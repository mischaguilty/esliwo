@section('title', implode(' ', [$vehicle->name, implode('-', [$vehicle->year_start, $vehicle->year_end]), implode(', ', $vehicle->bodytypes)]))

<div>
    <h1>@yield('title')</h1>

    <div class="list-group mb-3">
        @forelse($products as $product)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('products.show', ['product' => $product]) }}"
                                   class="text-decoration-none">
                                    <strong class="text-dark">{{ $product->elsie_code }}</strong>
                                    <span class="text-secondary">{{ $product->name }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-auto">
                        @forelse($product->stock_products()->get() as $stockProduct)
                            @if($actualPrice = $stockProduct->actual_price)
                                <div class="text-success">
                                    {{ $actualPrice->price }}
                                </div>
                            @else
                                <div class="text-danger">{{ __('No prices found') }}</div>
                            @endif
                            @if($stock = $stockProduct->stock()->first())
                                <div>{{ $stock->name }}</div>
                            @endif
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div>{{ __('No products found') }}</div>
        @endforelse
    </div>

    <x-ui::pagination :links="$products"/>
</div>
