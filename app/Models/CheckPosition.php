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
 * @property int $supply_info_id
 * @property-read SupplyInfo $supplyInfo
 * @property int $sale_id
 * @property Sale $sale
 * @property int $quantity
 * @method static Builder|CheckPosition newModelQuery()
 * @method static Builder|CheckPosition newQuery()
 * @method static Builder|CheckPosition query()
 * @method static Builder|CheckPosition whereCreatedAt($value)
 * @method static Builder|CheckPosition whereId($value)
 * @method static Builder|CheckPosition whereQuantity($value)
 * @method static Builder|CheckPosition whereSaleId($value)
 * @method static Builder|CheckPosition whereSupplyId($value)
 * @method static Builder|CheckPosition whereUpdatedAt($value)
 */
class CheckPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'sale_id',
        'supply_info_id',
    ];

    public function supplyInfo(): BelongsTo
    {
        return $this->belongsTo(SupplyInfo::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
