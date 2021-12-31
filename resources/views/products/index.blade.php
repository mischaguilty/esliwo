@section('title', __('Products'))

<div>
    <h1>@yield('title')</h1>

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Products') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
        <div class="col-lg-auto mb-3 flex-shrink-1">
            <div class="input-group">
                @foreach($placements as $placement)
                    <button class="btn shadow-none {{ $selectedPlacement === $placement ? 'btn-secondary' : 'btn-outline-secondary' }}"
                            type="button" wire:click="$set('selectedPlacement', '{{ $placement }}')">
                        {{ __(implode(' ', ['Placement', $placement])) }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($products as $product)
            <livewire:products.item :product="$product"
                                    wire:key="{{ implode('_', ['product', $loop->index, $product->id]) }}"/>
        @empty
            <div class="list-group-item text-center">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$products"/>
</div>
