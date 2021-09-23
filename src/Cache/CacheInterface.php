<?php

declare(strict_types = 1);

namespace App\Cache;

interface CacheInterface
{
    /**
     * Return cached entry or retrieve updated one by callback.
     *
     * @param string $key
     * @param callable $callback
     * @return mixed
     */
    public function get(string $key, callable $callback);

    /**
     * Invalidate all entries that conains at least one of following tags
     *
     * @param array $tags
     */
    public function invalidateTags(array $tags): void;
}
