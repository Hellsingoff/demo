<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\StoreTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property string $area
 * @property string $address
 * @property StoreTypeEnum $type
 * @property string $utility_costs
 * @method static Builder|Store newModelQuery()
 * @method static Builder|Store newQuery()
 * @method static Builder|Store query()
 * @method static Builder|Store whereAddress($value)
 * @method static Builder|Store whereArea($value)
 * @method static Builder|Store whereCreatedAt($value)
 * @method static Builder|Store whereId($value)
 * @method static Builder|Store whereName($value)
 * @method static Builder|Store whereType($value)
 * @method static Builder|Store whereUpdatedAt($value)
 * @method static Builder|Store whereUtilityCosts($value)
 * @method static Builder where(string $field, string $operator, mixed $value = null);
 * @property-read Collection<int, Supply> $supplies
 * @property-read int|null $supplies_count
 */
class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'area',
        'address',
        'type',
        'utility_costs',
    ];

    protected $casts = [
        'type' => StoreTypeEnum::class,
    ];

    public function suppliesInStock(): HasMany
    {
        return $this->supplies()->where('quantity', '!=', 0);
    }

    public function supplies(): HasMany
    {
        return $this->hasMany(Supply::class);
    }
}
