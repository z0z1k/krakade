<?php

    function createOrder(array $params)
    {
        $sql = "INSERT INTO `orders` (`client_address`, `client_phone`, `place`, `tg_message_id`, `orderComent`, `paymentType`) VALUES (:address, :phone, :place, :m_id, :orderComent, :paymentType)";
        dbQuery($sql, $params);
    }

    function getActiveOrders(string $place)
    {
        $params = ['place' => $place];
        $sql = "SELECT * FROM `orders` WHERE `dt_delivered` IS NULL AND `place` = :place";
        return dbQuery($sql, $params)->fetchAll();
    }

    function getAllActiveOrders()
    {
        $sql = "SELECT * FROM `orders` WHERE `dt_delivered` IS NULL";
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

    function validateErrors(array &$fields) : array {
        $errors = [];

        $fields['address'] = trim($fields['address']);
        $fields['phone'] = trim($fields['phone']);
        $fields['beReady'] = trim($fields['beReady']);
        $fields['paymentType'] = trim($fields['paymentType']);

        if (mb_strlen($fields['address'], 'UTF-8') < 10) {
            $errors[] = 'Адреса не може бути коротша 10 символів';
        }

        if (mb_strlen($fields['phone'], 'UTF-8') < 10) {
            $errors[] = "Номер телефону не може бути коротший 10 символів";
        }

        if (mb_strlen($fields['beReady'], 'UTF-8') < 5) {
            $errors[] = "Невірно вказаний час";
        }

        if ($fields['paymentType'] == ''){
            $fields['paymentType'] = "Оплата не потрібна";
        } else {
            $fields['paymentType'] = "Потрібно оплатити " . $fields['paymentType'] . " грн";
        }

        $fields['paymentType'] = htmlspecialchars($fields['paymentType']);
        $fields['address'] = htmlspecialchars($fields['address']);
        $fields['phone'] = htmlspecialchars($fields['phone']);

        return $errors;
    }