@section('title', $product->elsie_code)

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('products') }}" class="text-decoration-none text-secondary">
                    {{ __('Products') }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('products.show', ['product' => $product]) }}" class="text-decoration-none text-black">
                    {{ $product->elsie_code }}
                </a>
            </li>
        </ol>
    </nav>

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
    @forelse($product->stocks()->get() as $stock)
        <livewire:stock-products.item :stock="$stock" :product="$product"/>
    @empty
    @endforelse
</div>
