<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property float $price
 * @property string $provider
 * @property string $description
 * @property int $barcode
 * @method static Builder|SupplyInfo newModelQuery()
 * @method static Builder|SupplyInfo newQuery()
 * @method static Builder|SupplyInfo query()
 * @method static Builder|SupplyInfo whereCreatedAt($value)
 * @method static Builder|SupplyInfo whereDescription($value)
 * @method static Builder|SupplyInfo whereId($value)
 * @method static Builder|SupplyInfo whereName($value)
 * @method static Builder|SupplyInfo wherePrice($value)
 * @method static Builder|SupplyInfo whereProvider($value)
 * @method static Builder|SupplyInfo whereUpdatedAt($value)
 * @method static Builder whereIn(string $column, mixed[] $values)
 * @method static SupplyInfo create(array $params)
 * @property int $store_id
 * @property int $quantity
 * @method static Builder|SupplyInfo whereProviderId($value)
 * @method static Builder|SupplyInfo whereQuantity($value)
 * @method static Builder|SupplyInfo whereStoreId($value)
 * @property-read Collection<int, Provider> $providers
 * @property-read int|null $providers_count
 */
class SupplyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'barcode'
    ];

    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(Provider::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Supply::class);
    }
}
