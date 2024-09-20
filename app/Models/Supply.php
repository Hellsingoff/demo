<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property float $price
 * @property string $provider
 * @property string $description
 * @method static Builder|Supply newModelQuery()
 * @method static Builder|Supply newQuery()
 * @method static Builder|Supply query()
 * @method static Builder|Supply whereCreatedAt($value)
 * @method static Builder|Supply whereDescription($value)
 * @method static Builder|Supply whereId($value)
 * @method static Builder|Supply whereName($value)
 * @method static Builder|Supply wherePrice($value)
 * @method static Builder|Supply whereProvider($value)
 * @method static Builder|Supply whereUpdatedAt($value)
 * @method static Supply create(array $params)
 * @property int $store_id
 * @property int $quantity
 * @method static Builder|Supply whereProviderId($value)
 * @method static Builder|Supply whereQuantity($value)
 * @method static Builder|Supply whereStoreId($value)
 * @property int $supply_info_id
 * @property-read Store $store
 * @property-read SupplyInfo $supplyInfo
 * @method static Builder|Supply whereSupplyInfoId($value)
 */
class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'supply_info_id',
        'quantity',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function supplyInfo(): BelongsTo
    {
        return $this->belongsTo(SupplyInfo::class);
    }
}
