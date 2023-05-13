<?php

    setcookie('token', '', time() - 3600, BASE_URL);
    unset($_SESSION['token']);

    header('Location: ' . BASE_URL);
    exit();