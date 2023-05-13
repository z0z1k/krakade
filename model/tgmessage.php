<?php

    function message_to_telegram($text)
    {
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_POSTFIELDS => array(
                    'chat_id' => TELEGRAM_CHATID,
                    'text' => $text,
                ),
            )
        );
        $res = curl_exec($ch);
        return json_decode($res, true);
    }

    function deleteMessage($msg)
    {
        $getQuery = array(
            "chat_id" 	=> TELEGRAM_CHATID,
            "message_id"  => $msg,
        );
        $ch = curl_init("https://api.telegram.org/bot". TELEGRAM_TOKEN ."/deleteMessage?" . http_build_query($getQuery));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        
        $resultQuery = curl_exec($ch);
        curl_close($ch);
    }