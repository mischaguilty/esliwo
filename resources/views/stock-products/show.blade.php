@section('title', $stockProduct->product->elsie_code.' - '.$stockProduct->stock->name)

@push('styles')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@push('scripts')
    @livewireChartsScripts
@endpush

<div>
    <h1>@yield('title')</h1>
    <h5>{{ $stockProduct->product->name }}</h5>
    <h6>{{ $stockProduct->product->vehicle ? $stockProduct->product->vehicle->full_name : '' }}</h6>
    @php
        $chartModel = \Asantibanez\LivewireCharts\Facades\LivewireCharts::lineChartModel();
        $stockProduct->prices()->get()->each(function (\App\Models\StockProductPrice $price) use (&$chartModel) {
        $chartModel = $chartModel->addMarker($price->created_At, $price->price, 'green');
    });
    @endphp
    {{ dd($chartModel) }}
    @if($chartModel)
        <livewire:livewire-line-chart
                key="{{ $chartModel->reactiveKey() }}"
                :line-chart-model="$chartModel"
        />
    @else
        <button class="btn btn-primary" wire:click="getStockInfo" wire:loading.class="disabled">

            {{ __('Get Stock Info ?') }}
        </button>

        <div wire:loading wire:target="getStockInfo">{{ __('Loading') }}</div>

    @endif
</div>
