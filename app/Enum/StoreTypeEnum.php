<?php

namespace App\Enum;

enum StoreTypeEnum: string
{
    case Shop = 'shop';
    case Minimarket = 'minimarket';
    case Market = 'market';

    public function label(): string
    {
        return match ($this) {
            self::Shop => 'Магазин',
            self::Minimarket => 'Киоск',
            self::Market => 'Супермаркет',
        };
    }
}
