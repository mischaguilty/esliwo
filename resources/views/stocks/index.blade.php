@section('title', __('Stocks'))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('stocks') }}" class="text-decoration-none text-black">
                    {{ __('Stocks') }}
                </a>
            </li>
        </ol>
    </nav>
    <h1>@yield('title')</h1>

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Stocks') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($stocks as $stock)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('stocks.show', ['stock' => $stock]) }}"
                                   class="text-decoration-none text-dark fw-bold"
                                   title="{{ implode(' ', [__('Source ID'), $stock->shop_id]) }}">
                                    {{ $stock->name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-auto">
                        <a href="{{ route('stock-products', ['stock' => $stock]) }}" class="text-decoration-none">
                            <div class="text-center">
                                <div class="text-dark fw-bolder">
                                    {{ $stock->products_count }}
                                </div>
                                <div class="text-secondary fw-lighter">
                                    {{ __('products in stock') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>
</div>
