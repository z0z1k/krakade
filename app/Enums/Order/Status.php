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

    public function routeLink()
    {
        return match ($this->value) {
            self::CREATED->value => 'orders.show',
            self::COURIER_FOUND->value => 'orders.get',
            self::TAKEN->value => 'orders.setDelivered',
            self::DELIVERED->value => 'orders.show',
            self::CANCELLED->value => 'orders.show',
        };
    }

    public function routeMethod()
    {
        return match ($this->value) {
            self::CREATED->value => 'get',
            self::COURIER_FOUND->value => 'post',
            self::TAKEN->value => 'post',
            self::DELIVERED->value => 'get',
            self::CANCELLED->value => 'get',
        };   
    }

    public function textForCourier()
    {
        return match ($this->value) {
            self::CREATED->value => 'Взяти замовлення',
            self::COURIER_FOUND->value => 'Отримав замовлення',
            self::TAKEN->value => 'Доставлено',
            self::DELIVERED->value => 'Замовлення закрите',
            self::CANCELLED->value => 'Замовлення скасоване',
        };   
    }
}