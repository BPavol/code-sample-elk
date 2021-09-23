<?php

declare(strict_types = 1);

namespace App\Cache;

final class RedisCache implements CacheInterface
{
    /**
     * @inheritDoc
     */
    public function get(string $key, callable $callback)
    {

    }

    /**
     * @inheritDoc
     */
    public function invalidateTags(array $tags): void
    {

    }
}
