<?php

namespace System;
use System\DataBase\Connection;
use System\DataBase\QuerySelect;
use System\DataBase\SelectBuilder;

class User
{
    public static $instance = null;
    public ?string $userName = null;
    public ?int $userID = null;
    protected object $session;
    protected object $qs;

    protected function __construct()
    {
        $this->qs = new QuerySelect(Connection::getInstance(), (new SelectBuilder('users')));
        $this->session = Session::getInstance();
        $token = $_SESSION['token'] ?? $_COOKIE['token'] ?? null;

        if($token !== null) {
            $session = $this->session->get($token);
            
            if ($session !== null) {
                $this->userID = $session[0]['id_user'];
                $user = $this->qs->where("id_user = '$this->userID'")->get();
                $this->userName = $user[0]['name'];
            }
        }
    }

    public static function getInstance() : static
	{
		if (static::$instance === null) {
			static::$instance = new static();
		}

		return static::$instance;
	}

    public function getID()
    {
        return $this->userID;
    }

    public function getName()
    {
        return $this->userName;
    }
}