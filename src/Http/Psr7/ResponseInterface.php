<?php

declare(strict_types=1);

namespace App\Http\Psr7;

interface ResponseInterface
{
    /**
     * Gets the body of the message.
     *
     * @return string|null
     */
    public function getBody(): ?string;

    /**
     * @return int
     */
    public function getStatus(): int;
}
