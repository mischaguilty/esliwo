<div>
    <div class="list-group-item list-group-item-action">
        <div class="row align-items-center">
            <div class="col-lg mb-2 mb-lg-0">
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="{{ route('products.show', ['product' => $product]) }}"
                           class="text-decoration-none text-dark" data-bs-toggle="tooltip"
                           data-bs-placement="top" title="{{ __('Go to product').' '.$product->name }}">
                            <strong>{{ $product->elsie_code }}</strong>
                            @isset($product->stock_code)<span>({{ $product->stock_code }})</span>@endisset
                            @if($manufacturer = $product->manufacturer)<strong>{{ $manufacturer->name }}</strong>@endif
                            @if($product->size)<span>{{ $product->size }}</span>@endif
                        </a>
                    </li>
                    <li>
                        <span class="text-dark">
                            {{ $product->search_name ?? $product->name }}
                        </span>
                    </li>
                    @if($product->note)
                        <li>
                            <small class="text-secondary">
                                {{ $product->note }}
                            </small>
                        </li>
                    @endif
                    @if(!$product->search_name)
                        <li>
                            @if($vehicle = $product->vehicle)
                                <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}"
                                   class="text-decoration-none">
                                <span class="text-dark">
                                    {{ $vehicle->name }} ({{ $vehicle->year_start }}
                                    -{{ $vehicle->year_end ?? __('now') }})
                                    {{ implode(', ', $vehicle->bodytypes) }}
                                </span>
                                </a>
                            @endif
                        </li>
                    @endif
                    <li>
                        {{--                        @forelse($producwhereCount('prices')->whereHas('quantities')->get() as $stockProduct)--}}
                        {{--                            <div>--}}
                        {{--                                <strong class="text-primary">--}}
                        {{--                                    {{ $stockProduct->stock->name }} - {{ $stockProduct->actual_quantity->quantity }}--}}
                        {{--                                </strong>--}}
                        {{--                                @if($price = $stockProduct->actual_price)--}}
                        {{--                                    <strong class="text-success">--}}
                        {{--                                        {{ $price->price }} {{ $price->currency }}--}}
                        {{--                                    </strong>--}}
                        {{--                                    <small class="text-secondary">--}}
                        {{--                                        {{ now()->sub($price->created_at)->diffForHumans() }}--}}
                        {{--                                    </small>--}}
                        {{--                                @endif--}}
                        {{--                            </div>--}}
                        {{--                        @empty--}}
                        {{--                            <small class="text-danger">{{ __('Not found at stocks') }}</small>--}}
                        {{--                        @endforelse--}}
                    </li>
                </ul>
            </div>
            <div class="col-lg-auto text-center">
                @if(is_a($price, \App\Models\StockProductPrice::class))
                    <div>
                    <strong class="text-success">{{ $price->price }}</strong> <small class="text-success">{{ __($price->currency) }}</small>
                    </div>
                @endif
                @if(is_a($quantity, \App\Models\StockProductQuantity::class))
                    <div>
                    <strong class="text-primary">{{ $quantity->quantity }}</strong> <small class="text-primary">{{ __($quantity->units) }}</small>
                    </div>
                @endif

                {{--                            <li>--}}
                {{--                @forelse($product->stock_products()->get() as $stockProduct)--}}
                {{--                    <div>--}}
                {{--                        <strong class="text-primary">--}}
                {{--                            {{ $stockProduct->stock->name }} @if($quantity = $stockProduct->actual_quantity())--}}
                {{--                                ({{ $quantity->quantity }})@endif--}}
                {{--                        </strong>--}}
                {{--                        @if($price = $stockProduct->actual_price)--}}
                {{--                            <strong class="text-success">--}}
                {{--                                {{ $price->price }} {{__('UAH')}}--}}
                {{--                            </strong>--}}
                {{--                            <small class="text-secondary">--}}
                {{--                                {{ now()->sub($price->created_at)->diffForHumans() }}--}}
                {{--                            </small>--}}
                {{--                        @endif--}}
                {{--                    </div>--}}
                {{--                @empty--}}
                {{--                    <small class="text-danger">{{ __('Not found at stocks') }}</small>--}}
                {{--                @endforelse--}}
                {{--                            </li>--}}

                {{--                <x-ui::action icon="eye" :title="__('Read')"--}}
                {{--                              click="$emit('showModal', 'products.read', {{ $product->id }})"/>--}}

                {{--                <x-ui::action icon="pencil-alt" :title="__('Update')"--}}
                {{--                              click="$emit('showModal', 'products.save', {{ $product->id }})"/>--}}

                {{--                <x-ui::action icon="trash-alt" :title="__('Delete')" click="delete({{ $product->id }})"--}}
                {{--                              onclick="confirm('{{ __('Are you sure?') }}') || event.stopImmediatePropagation()"/>--}}
            </div>
        </div>
    </div>
</div>
