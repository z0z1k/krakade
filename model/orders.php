<?php

    function createOrder(array $params)
    {
        $sql = "INSERT INTO `orders` (`client_address`, `client_phone`, `place`, `tg_message_id`, `orderComent`, `paymentType`, `beReady`) VALUES (:address, :phone, :place, :m_id, :orderComent, :paymentType, :beReady)";
        dbQuery($sql, $params);
    }

    function getActiveOrders(string $place)
    {
        $params = ['place' => $place];
        $sql = "SELECT * FROM `orders` LEFT JOIN `users` on `orders`.`courier_id`=`users`.`id_user` WHERE `dt_delivered` IS NULL AND `place` = :place";
        return dbQuery($sql, $params)->fetchAll();
    }

    function getAllActiveOrders()
    {
        $sql = "SELECT * FROM `orders` LEFT JOIN `users` on `orders`.`courier_id`=`users`.`id_user` WHERE `dt_delivered` IS NULL";
        return dbQuery($sql)->fetchAll();
    }

    function getCompleteOrders(string $place)
    {
        $params = ['place' => $place];
        $sql = "SELECT * FROM `orders` WHERE `dt_delivered` IS NOT NULL AND `place` = :place";
        return dbQuery($sql, $params)->fetchAll();
    }

    function setActive($id)
    {
        $sql = "UPDATE `orders` SET `dt_get` = CURRENT_TIMESTAMP() WHERE `orders`.`order_id` = $id";
        return dbQuery($sql);
    }

    function setReady($id)
    {
        $sql = "UPDATE `orders` SET `dt_delivered` = CURRENT_TIMESTAMP() WHERE `orders`.`order_id` = $id";
        return dbQuery($sql);
    }

    function getTgIdByOrId($id)
    {
        $sql = "SELECT `tg_message_id` FROM `orders` WHERE `orders`.`order_id` = $id";
        $res = dbQuery($sql)->fetch();
        return $res['tg_message_id'];
    }

    function setCourier(int $idOrd, int $idCour)
    {
        $params = ['idOrd' => $idOrd, 'idCour' => $idCour];
        $sql = "UPDATE `orders` SET `courier_id` = :idCour WHERE `orders`.`order_id` = :idOrd";
        return dbQuery($sql, $params);
    }

    function getOrder(int $idOrd)
    {
        $params = ['id' => $idOrd];
        $sql = "SELECT * FROM `orders` WHERE `order_id` = :id";
        return dbQuery($sql, $params)->fetch();
    }

    function updateTgId(int $idOrd, int $tg_message_id)
    {
        $sql = "UPDATE `orders` SET `tg_message_id` = $tg_message_id WHERE `orders`.`order_id` = $idOrd";
        return dbQuery($sql);
    }

    function updateOrder($params)
    {
        $sql = "UPDATE `orders` SET `beReady` = :beReady, `client_address` = :address, `client_phone` = :phone, `paymentType` = :paymentType, `orderComent` = :orderComent, `tg_message_id` = :m_id WHERE `orders`.`order_id` = :order_id";
        dbQuery($sql, $params);
    }

    function validateErrors(array &$fields) : array
    {
        $errors = [];

        $fields['address'] = trim($fields['address']);
        $fields['phone'] = trim($fields['phone']);
        $fields['beReady'] = trim($fields['beReady']);
        $fields['paymentType'] = trim($fields['paymentType']);

        if (mb_strlen($fields['address'], 'UTF-8') < 10) {
            //$errors[] = 'Адреса не може бути коротша 10 символів';
        }

        if (mb_strlen($fields['phone'], 'UTF-8') < 10) {
            //$errors[] = "Номер телефону не може бути коротший 10 символів";
        }

        if (mb_strlen($fields['beReady'], 'UTF-8') < 5) {
            //$errors[] = "Невірно вказаний час";
        }

        if ($fields['paymentType'] == ''){
            $fields['paymentType'] = "Оплата не потрібна";
        } else if (!str_contains($fields['paymentType'], "Потрібно оплатити")){
            $fields['paymentType'] = "Потрібно оплатити " . $fields['paymentType'] . " грн";
        }

        $fields['paymentType'] = htmlspecialchars($fields['paymentType']);
        $fields['address'] = htmlspecialchars($fields['address']);
        $fields['phone'] = htmlspecialchars($fields['phone']);

        return $errors;
    }
