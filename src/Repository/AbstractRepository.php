<?php

namespace App\Repository;

abstract class AbstractRepository
{
    /**
     * Return exactly one entry
     *
     * @param $id
     */
    public function find($id): object
    {

    }

    /**
     * Return all entries
     *
     * @param int|null $limit
     * @param int|null $offset
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
     */
    public function findBy(array $criteria, ?int $limit = null, ?int $offset = null): array
    {

    }
}
