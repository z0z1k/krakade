<?php

    setReady($routerRes['params']['id']);
    deleteMessage(getTgIdByOrId($routerRes['params']['id']));

    header('Location: ' . BASE_URL);
    exit();