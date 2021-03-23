<?php

namespace App\Cache;

class RedisCache implements CacheInterface
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
