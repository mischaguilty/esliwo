<div>
    <div class="d-block">
        <form wire:action="submit">
                    <div class="flex-sm-wrap flex-md-nowrap row justify-content-between mb-3">
                        <div class="col-md-5 col-lg-4 col-sm-12 mb-3 mb-md-0">
                            <div class="input-group flex-nowrap">
                        <span class="input-group-text">
                    <i class="fa fa-barcode"></i>
                </span>
                                <input type="search" placeholder="{{ __('Search by code') }}"
                                       class="form-control text-uppercase shadow-none" wire:model.defer="model.codeSearch">

                            </div>
                        </div>
                        <div class="col-md-7 col-lg-8 col  col-sm-12 ">
                            <div class="input-group flex-nowrap">
                        <span class="input-group-text">
                            <i class="fa fa-shopping-bag text-secondary"></i>
                        </span>
                                <input type="search" placeholder="{{ __('Search by name') }}"
                                       class="form-control text-uppercase shadow-none" wire:model.defer="model.nameSearch">
                            </div>
                        </div>
                    </div>
                    <div class="flex-wrap flex-sm-nowrap w-100 d-flex justify-content-end mb-0 mb-sm-3">
                        <button type="button" class="btn btn-primary shadow-none flex-shrink-1"
                                Wire:click="search"
                                wire:loading.attr="disabled">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>
                </form>

        <div class="list-group">
        @forelse($results as $result)
            <livewire:stocks.item :stock="$result" wire:key="{{ implode('a', ['stock', $loop->index, now()->timestamp]) }}"/>
{{--            <livewire:products.item :product="$result->product"--}}
{{--                                    wire:key="{{ implode('_', ['product', $loop->index, $result->product->id]) }}"/>--}}
        @empty
            <div class="list-group-item text-center">
                {{ __('No results found.') }}
            </div>
        @endforelse
    </div>
        <x-ui::pagination :links="$results"/>
    </div>
</div>
