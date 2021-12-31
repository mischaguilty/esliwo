@section('title', $product->elsie_code)

<div>
    <h1>@yield('title')</h1>
    <p>{{ $product->name }}</p>

    <div class="my-3 justify-content-around d-inline-flex w-100">
        @if($vehicle = $product->vehicle)
            <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}" class="text-decoration-none">
                <div class="d-flex align-items-center text-secondary">
                    <div class="flex-shrink-0">
                        <i class="fa fa-2x fa-car-alt text-secondary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div>{{ $vehicle->name }}
                            ({{ $vehicle->year_start }}-{{ $vehicle->year_stop ?? __('now') }})
                            {{ implode(', ', $vehicle->bodytypes) }}
                        </div>
                        <div>{{ $vehicle->code }}</div>
                    </div>
                </div>
            </a>
        @endif

        @if($manufacturer = $product->manufacturer)
            <a href="{{ route('manufacturers.show', ['manufacturer' => $manufacturer]) }}" class="text-decoration-none">
                <div class="d-flex align-items-center text-secondary">
                    <div class="flex-shrink-0">
                        <i class="fas fa-2x fa-industry text-secondary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        {{ $manufacturer->name }}
                        {{ $manufacturer->country }}
                        <small>
                            ({{ $manufacturer->code_suffix }})
                        </small>
                    </div>
                </div>
            </a>
        @endif
    </div>
    @forelse(\App\Models\Stock::query()->get()->chunk(3) as $chunk)
        <div class="my-3 justify-content-between d-inline-flex w-100">
            @forelse($chunk->all() as $stock)
                @if($stockProduct = \App\Models\StockProduct::query()->firstOrCreate(['stock_id' => $stock->id, 'product_id' => $product->id]))
                    <a href="{{ route('stock-products.show', ['sProduct' => $stockProduct]) }}"
                       class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                @php($presented = $stockProduct->quantities()->count() !== 0)
                                <i class="fa fa-2x {{ $presented ? 'fa-store' : 'fa-store-slash' }} {{ $presented ? 'text-success' : 'text-secondary' }}"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-dark">
                                    {{ $stock->name }}
                                </div>
                                @if($q = $stockProduct->actual_quantity)
                                    <div class="text-primary">
                                        {{ __('In Stock') }}: {{ $q->quantity  }}
                                    </div>
                                @endif
                                @if($p = $stockProduct->actual_price)
                                    <div class="text-success">
                                        {{ $p->price }} {{ $p->currency }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endif
            @empty
            @endforelse
        </div>
    @empty
    @endforelse
</div>
