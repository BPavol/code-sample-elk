<?php

namespace App\Message;

/**
 * Message for message handler
 */
class ElasticsearchProductMessage
{
    private int $id;
    private bool $forDelete;

    public function __construct(int $id, bool $forDelete = false)
    {
        $this->id = $id;
        $this->forDelete = $forDelete;
    }

    /**
     * Return product id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set to true if product have to be deleted in Elasticsearch
     *
     * @return bool
     */
    public function isForDelete()
    {
        return $this->forDelete;
    }
}
