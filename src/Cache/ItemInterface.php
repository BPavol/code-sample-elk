<?php

namespace App\Cache;

interface ItemInterface
{
    /**
     * Number of seconds after entry will be invalid
     *
     * @param int $seconds
     */
    public function expiresAfter(int $seconds): void;

    /**
     * Tag entry to be invalidated later
     *
     * @param array|string $tags
     */
    public function tag(array|string $tags): void;
}
