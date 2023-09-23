<?php

namespace System;

use System\DataBase\Connection;
use System\DataBase\QuerySelect;
use System\Database\SelectBuilder;

class Session
{
    protected object $qs;
    public static $instance = null;

    public static function getInstance() : static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function get($token)
    {
        return $this->qs->where("token = '$token'")->get();
    }

    protected function __construct()
    {
        $this->qs = new QuerySelect(Connection::getInstance(), (new SelectBuilder('sessions')));
    }
}