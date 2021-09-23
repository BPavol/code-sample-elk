<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Psr7\ResponseInterface;

class Response implements ResponseInterface
{
    /** @var string|null */
    private ?string $body;

    /** @var int */
    private int $status;

    public function __construct(?string $body = null, int $status = 200)
    {
        $this->body = $body;
        $this->status = $status;
    }

    /**
     * @inheritDoc
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
