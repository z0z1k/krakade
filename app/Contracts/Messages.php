<?php

namespace App\Contracts;

interface Messages
{
    public function send($message) : int;
    public function delete();
    public function update();
}