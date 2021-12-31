<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use PowerJoins;

    protected $table = 'products';

    protected $fillable = [
        'manufacturer_id',
        'vehicle_id',
        'name',
        'stock_code',
        'elsie_code',
        'width',
        'height',
        'search_name',
        'note',
    ];

    public function scopeGlasses(Builder $builder): Builder
    {
        return $builder
            ->whereRaw('`elsie_code` NOT REGEXP ' . '"^[[:alnum:]]{5}S[[:alnum:]]*-?[[:alnum:]]*$"')
            ->whereRaw('`elsie_code` NOT REGEXP ' . '"^[[:alnum:]]{5}K[[:alnum:]]*-?[[:alnum:]]*$"');
    }

    public function scopeAccessories(Builder $builder): Builder
    {
        return $builder
            ->whereRaw('`elsie_code` REGEXP ' . '"^[[:alnum:]]{5}S[[:alnum:]]*-?[[:alnum:]]*$"')
            ->whereRaw('`elsie_code` REGEXP ' . '"^[[:alnum:]]{5}K[[:alnum:]]*-?[[:alnum:]]*$"');
    }

    public static function suggestedManufacturer(string $suffix): ?Manufacturer
    {
        return optional(Manufacturer::query()->firstWhere([
                'code_suffix' => $suffix,
            ]) ?? null, function (Manufacturer $manufacturer) {
            return $manufacturer;
        });
    }

    public static function parseCode(string $elsieCode): ?array
    {
        $parsed = collect(explode('.', $elsieCode));
        $productCode = $parsed->first();
        $defectCode = $parsed->count() === 2 ? $parsed->last() : null;
        $parsed = collect(explode('-', $productCode));
        $productCode = $parsed->first();
        $manufacturerCode = $parsed->count() === 2 ? $parsed->last() : null;
        $vehicleCode = substr($productCode, 0, 4);

        return [
            'product_code' => $productCode,
            'vehicle_code' => $vehicleCode,
            'defect_code' => $defectCode,
            'manufacturer_code' => $manufacturerCode,
        ];
    }

    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, StockProduct::class, 'product_id', 'stock_id', 'id', 'id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }

    public function stock_products(): HasMany
    {
        return $this->hasMany(StockProduct::class, 'product_id', 'id');
    }
}
