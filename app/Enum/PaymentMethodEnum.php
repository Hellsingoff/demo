<?php

namespace App\Enum;

enum PaymentMethodEnum: string
{
    case Card = 'card';
    case Cash = 'cash';

    public function label(): string
    {
        return match ($this) {
            self::Card => 'Картой',
            self::Cash => 'Наличными',
        };
    }
}
