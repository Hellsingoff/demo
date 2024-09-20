<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @method static Builder|Provider newModelQuery()
 * @method static Builder|Provider newQuery()
 * @method static Builder|Provider query()
 * @method static Builder|Provider whereCreatedAt($value)
 * @method static Builder|Provider whereId($value)
 * @method static Builder|Provider whereName($value)
 * @method static Builder|Provider whereUpdatedAt($value)
 * @method static Builder whereIn(string $column, mixed[] $values)
 * @method static Provider create($fields)
 * @property string|null $phone
 * @property-read Collection<int, SupplyInfo> $supplies
 * @property-read int|null $supplies_count
 * @method static Builder|Provider wherePhone($value)
 */
class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone'
    ];

    public function supplies(): BelongsToMany
    {
        return $this->belongsToMany(SupplyInfo::class);
    }
}
