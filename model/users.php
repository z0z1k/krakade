<?php
    
    function usersOne(string $login) : ?array
    {
        $sql = "SELECT * FROM `users` WHERE `login`=:login";
        $query = dbQuery($sql, ['login' => $login]);
        $user = $query->fetch();
        return $user === false ? null : $user;
    }

    function userByID(string $id) : ?array
    {
        $sql = "SELECT * FROM `users` WHERE `id_user`=:id";
        $query = dbQuery($sql, ['id' => $id]);
        $user = $query->fetch();
        return $user === false ? null : $user;
    }

    function createUser(array $params)
    {
        $sql = "INSERT INTO `users` (`login`, `password`, `email`, `name`, `address`, `number`) VALUES (:login, :password, :email, :name, :address, :number)";
        dbQuery($sql, $params);
    }