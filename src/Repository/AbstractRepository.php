<?php

declare(strict_types = 1);

namespace App\Repository;

abstract class AbstractRepository
{
    /**
     * Return exactly one entry
     *
     * @param $id
     * @return object|null
     */
    public function find($id): ?object
    {

    }

    /**
     * Return all entries
     *
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findAll(?int $limit = null, ?int $offset = null): array
    {

    }

    /**
     * Return filtered entries
     *
     * @param array $criteria
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findBy(array $criteria, ?int $limit = null, ?int $offset = null): array
    {

    }
}
