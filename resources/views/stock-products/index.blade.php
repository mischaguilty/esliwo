@section('title', implode(' ', [$stock->name, __('Products')]))

<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                    <i class="fa fa-home"></i>
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('stocks.show', ['stock' => $stock]) }}" class="text-decoration-none text-secondary">
                    {{ $stock->name }}
                </a>
            </li>

            <li class="breadcrumb-item active">
                <a href="{{ route('stock-products') }}" class="text-decoration-none text-black">
                    {{ __('Products') }}
                </a>
            </li>
        </ol>
    </nav>
    <h1>@yield('title')</h1>

    <div class="row justify-content-between">
        <div class="col-lg-auto mb-3 flex-grow-1">
            <div class="input-group">
                <span class="input-group-text"><x-ui::icon name="search"/></span>
                <input type="search" placeholder="{{ __('Search Products') }}"
                       class="form-control shadow-none" wire:model.debounce.500ms="search">
            </div>
        </div>
    </div>

    <div class="list-group mb-3">
        @forelse($sProducts as $sProduct)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <strong>{{ $sProduct->product->elsie_code }}</strong> - {{ $sProduct->product->name }}
                            </li>
                            <li>
                                <small class="text-secondary">
                                    {{ $sProduct->product->manufacturer ? $sProduct->product->manufacturer->name : 'null' }}
                                </small>
                            </li>
                            @if($vehicle = $sProduct->product->vehicle)
                                <li>
                                    <small class="text-secondary">
                                        {{ $vehicle->name }} ({{ $vehicle->year_start }}-{{ $vehicle->year_end }}
                                        ) {{ implode(', ', $vehicle->bodytypes) }}
                                    </small>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-auto text-center">
                        @if($price = $sProduct->actual_price)
                            <div>
                                <strong class="text-success">
                                    {{ $price->price }}
                                </strong>
                                <span>{{ __('UAH') }}</span>
                            </div>
                            <div>
                                <small>
                                    {{ now()->sub($price->created_at)->diffForHumans() }}
                                </small>
                            </div>
                        @endif
                        {{--                                            <x-ui::action icon="eye" :title="__('Read')"--}}
                        {{--                                                          click="$emit('showModal', 'vehicles.read', {{ $vehicle->id }})"/>--}}
                        {{----}}
                        {{--                                            <x-ui::action icon="pencil-alt" :title="__('Update')"--}}
                        {{--                                                          click="$emit('showModal', 'vehicles.save', {{ $vehicle->id }})"/>--}}
                        {{----}}
                        {{--                                            <x-ui::action icon="trash-alt" :title="__('Delete')" click="delete({{ $vehicle->id }})"--}}
                        {{--                                                          onclick="confirm('{{ __('Are you sure?') }}') || event.stopImmediatePropagation()"/>--}}
                    </div>
                </div>
            </div>
        @empty
            <div class="list-group-item">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>

    <x-ui::pagination :links="$sProducts"/>
</div>
