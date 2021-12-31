<?php

namespace App\Console\Commands;

use App\Actions\ElsieCodesQuantitiesAction;
use App\Actions\ElsiePriceDownloadAction;
use App\Actions\ElsieShowTrashAction;
use App\Actions\ElsieTrashAction;
use App\Actions\ElsieVehicleProductsPricesAction;
use App\Actions\VehicleProductsPricesQuantitiesAction;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\Vehicle;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getProductWithPrices()
    {
        $product = optional(Product::query()->with('vehicles')->find(6409) ?? null, function (Product $product) {
            return [
                'car' => optional($product->vehicles()->first() ?? null, function (Vehicle $vehicle) {
                    return $vehicle->name;
                }),
                'name' => $product->name ?? $product->search_name,
                'stocks' => $product->stock_products()->with('prices')->get()->toBase()->map(function (StockProduct $stockProduct) {
                    return [
                        'name' => optional($stockProduct->stock()->first() ?? null, function (Stock $stock) {
                            return $stock->name;
                        }),
                        'price' => optional($stockProduct->prices()->latest()->first() ?? null, function (Price $price) {
                            return $price->price;
                        }),
                    ];
                }),
            ];
        });
        dd($product);
    }

    protected function getVehicleSearch()
    {
        Vehicle::query()
            ->whereNotNull([
                'code',
            ])
            ->inRandomOrder()
            ->get()
            ->each(function (Vehicle $vehicle) {
                $this->info($vehicle->code);
                ElsieVehicleProductsPricesAction::make()->handle($vehicle);
            })->dd();
    }


    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle(): int
    {

//        Excel::import(new PriceImport, public_path('Catalog_ELSIE_1640745420.xls'));
//        die;
        VehicleProductsPricesQuantitiesAction::make()->handle(Vehicle::query()->firstWhere([
            'code' => '3022',
        ]));
        die;

//        optional(Product::query()->where('elsie_code', 'like', '3003AGN%')->inRandomOrder()->first() ?? null, function (Product $product) {
//            ProductsPricesQuantitiesAction::make()->handle($product);
//        });

        die;

        Vehicle::query()
            ->inRandomOrder()
            ->get()->toBase()->each(function (Vehicle $vehicle) {
                $this->info($vehicle->full_name);
                optional(ElsieVehicleProductsPricesAction::make()->handle($vehicle) ?? null, function (Collection $codes) {
                    ElsieCodesQuantitiesAction::make()->handle($codes->toArray());
                });
            });
        die;


        optional(Vehicle::query()->whereHas('products', function (Builder $builder) {
                return $builder->whereHas('stock_products');
            })->inRandomOrder()
                ->first() ?? null, function (Vehicle $vehicle) {
            $this->info($vehicle->code);
            $this->info($vehicle->name);
            dd($vehicle->stock_products());
        });

        optional(StockProduct::query()
                ->whereHas('prices')
                ->inRandomOrder()
                ->first() ?? null, function (StockProduct $stockProduct) {
            dd($stockProduct->product->name, $stockProduct->actual_price->price);
        });

        die();

        auth()->loginUsingId(2);
        ElsieTrashAction::make()->handle(['3003AGNBL-XI.UC', '3003AGNBL-XI'], true, [18, 1]);
        $data = ElsieShowTrashAction::make()->handle();
        ElsieTrashAction::make()->handle(['3003AGNBL-XI.UC', '3003AGNBL-XI'], false, [18, 1]);
        dd($data);

        return 0;
    }
}
