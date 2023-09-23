<?php

namespace Models;

use System\User;

class Order extends Base
{
    protected static $instance;
    protected string $table = 'orders';
    protected string $fk = 'order_id';

    public function active()
    {
        return $this->selector()->where("place_id = :pID AND order_status < 10", ['pID' => 22])->get();
    }
}