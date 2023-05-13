<?php

    function sessionAdd(int $idUser, string $token)
    {
        $params = ['uid' => $idUser, 'token' => $token];
        $sql = "INSERT into `sessions` (id_user, token) VALUES (:uid, :token)";
        dbQuery($sql, $params);
    }

    function sessionGet(string $token)
    {
        $sql = "SELECT * FROM `sessions` WHERE `token`=:token";
        $query = dbQuery($sql, ['token' => $token]);
        $session = $query->fetch();
        return $session === false ? null : $session;
    }