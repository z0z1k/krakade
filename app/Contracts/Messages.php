<?php

namespace App\Contracts;

interface Messages
{
    public function send();
    public function delete();
    public function update();
}