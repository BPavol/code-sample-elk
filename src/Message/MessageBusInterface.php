<?php

namespace App\Message;

/**
 * Message dispatcher
 */
interface MessageBusInterface
{
    public function dispatch($message);
}