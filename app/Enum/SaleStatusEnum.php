<?php

namespace App\Enum;

enum SaleStatusEnum: string
{
    case New = 'new';
    case Paid = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новая',
            self::Paid => 'Оплачена',
        };
    }
}
