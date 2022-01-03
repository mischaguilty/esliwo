@section('title',  $stock->name)

<div>
    <h1>@yield('title')</h1>

    <div class="list-group mb-3">
        @forelse($stockProducts as $stockProduct)
            <div class="list-group-item list-group-item-action">
                <div class="row align-items-center">
                    <div class="col-lg mb-2 mb-lg-0">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('stock-products.show', ['stockProduct' => $stockProduct]) }}"
                                   class="text-decoration-none">
                                    <strong class="text-dark">
                                        {{ $stockProduct->name }}
                                    </strong>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-auto">
                        {{--                        <a href="{{ route('stock-products', ['stock' => $stock]) }}" class="text-decoration-none">--}}
                        {{--                            <div class="text-center">--}}
                        {{--                                <div class="text-dark fw-bolder">--}}
                        {{--                        {{ $stock->products_count }}--}}
                        {{--                                </div>--}}
                        {{--                                <div class="text-secondary fw-lighter">--}}
                        {{ __('products in stock') }}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </a>--}}

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

    {{--    <x-ui::pagination :links="$stockProducts"/>--}}
</div>
