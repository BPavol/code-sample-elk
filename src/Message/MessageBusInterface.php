<?php

declare(strict_types = 1);

namespace App\Message;

/**
 * Message dispatcher
 */
interface MessageBusInterface
{
    public function dispatch($message);
}