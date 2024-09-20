<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\SaleStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property User $user
 * @property int|null $customer_id
 * @property Customer|null $customer
 * @property string $payment_method
 * @property int $store_id
 * @property Store $store
 * @property SaleStatusEnum $status
 * @property-read Collection<int, CheckPosition> $positions
 * @method static Builder|Sale newModelQuery()
 * @method static Builder|Sale newQuery()
 * @method static Builder|Sale query()
 * @method static Builder|Sale whereCreatedAt($value)
 * @method static Builder|Sale whereCustomerId($value)
 * @method static Builder|Sale whereId($value)
 * @method static Builder|Sale wherePaymentMethod($value)
 * @method static Builder|Sale whereStoreId($value)
 * @method static Builder|Sale whereUpdatedAt($value)
 * @method static Builder|Sale whereUserId($value)
 */
class Sale extends Model
{
    use HasFactory;

    protected $fillable =[
        'payment_method',
        'user_id',
        'customer_id',
        'store_id',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(CheckPosition::class);
    }
}
