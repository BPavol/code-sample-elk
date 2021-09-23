<?php

declare(strict_types=1);

namespace App\Http;

final class JsonResponse extends Response
{
    public function __construct($body = null, int $status = 200)
    {
        parent::__construct(json_encode($body), $status);
    }
}
