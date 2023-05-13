<?php

    function dbInstance() : PDO
    {
        static $db;

        if ($db === null) {
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        
        return $db;
    }
   
    function dbQuery(string $sql, array $params = []) : PDOStatement
    {
        $db = dbInstance();
        $query = $db->prepare($sql);
        $query->execute($params);
        return $query;
    }