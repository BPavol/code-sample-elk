<?php

namespace App\Elasticsearch;

class EleasticsearchClient
{
    /**
     * Index new entry or reindex old one
     *
     * @param $id
     * @param array $body
     */
    public function index($id, array $body)
    {

    }

    /**
     * Find all results in Elasticsearch by query
     *
     * @param string $query
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function query(string $query, ?int $limit = null, ?int $offset = null)
    {

    }

    /**
     * Delete entry by ID
     *
     * @param $id
     */
    public function delete($id)
    {

    }
}
