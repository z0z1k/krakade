<?php

namespace App\Enums\Order;

enum Status : int
{
    case CREATED = 0;
    case COURIER_FOUND = 5;
    case TAKEN = 10;
    case DELIVERED = 15;
    case CANCELLED = 20;

    public function text()
    {
        return match ($this->value) {
            self::CREATED->value => "Шукаємо кур'єра",
            self::COURIER_FOUND->value => "Кур'єра знайдено",
            self::TAKEN->value => "Кур'єр отримав замовлення",
            self::DELIVERED->value => 'Замовлення доставлено',
            self::CANCELLED->value => 'Замовлення скасовано',
        };
    }
}