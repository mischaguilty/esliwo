@section('title', __('Stocks'))

<div>
    <h1>@yield('title')</h1>

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Stocks') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
        {{--        <div class="col-lg-auto mb-3">--}}
        {{--            <button type="button" class="btn btn-primary" wire:click="$emit('showModal', 'stocks.save')">--}}
        {{--                <x-ui::icon name="plus"/> {{ __('Create') }}--}}
        {{--            </button>--}}

        {{--            <x-ui::dropdown icon="sort" :label="__($sort)">--}}
        {{--                @foreach($sorts as $sort)--}}
        {{--                    <x-ui::dropdown-item :label="__($sort)" click="$set('sort', '{{ $sort }}')"/>--}}
        {{--                @endforeach--}}
        {{--            </x-ui::dropdown>--}}

        {{--            <x-ui::dropdown icon="filter" :label="__($filter)">--}}
        {{--                @foreach($filters as $filter)--}}
        {{--                    <x-ui::dropdown-item :label="__($filter)" click="$set('filter', '{{ $filter }}')"/>--}}
        {{--                @endforeach--}}
        {{--            </x-ui::dropdown>--}}
        {{--        </div>--}}
    </div>

    <div class="list-group mb-3">
        @forelse($stocks as $stock)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('stocks.show', ['stock' => $stock]) }}" class="text-decoration-none">
                                    <strong class="text-dark">
                                        {{ $stock->name }}
                                    </strong>
                                    <small class="text-secondary">({{ $stock->shop_id }})</small>
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

                        {{--                        <x-ui::action icon="eye" :title="__('Read')"--}}
                        {{--                                      click="$emit('showModal', 'stocks.read', {{ $stock->id }})"/>--}}

                        {{--                        <x-ui::action icon="pencil-alt" :title="__('Update')"--}}
                        {{--                                      click="$emit('showModal', 'stocks.save', {{ $stock->id }})"/>--}}

                        {{--                        <x-ui::action icon="trash-alt" :title="__('Delete')" click="delete({{ $stock->id }})"--}}
                        {{--                                      onclick="confirm('{{ __('Are you sure?') }}') || event.stopImmediatePropagation()"/>--}}
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$stocks"/>
</div>