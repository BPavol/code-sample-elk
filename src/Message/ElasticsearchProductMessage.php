<?php

declare(strict_types = 1);

namespace App\Message;

/**
 * Message for creating fulltext entry in Elasticsearch
 */
final class ElasticsearchProductMessage
{
    /** @var int  */
    private int $id;

    /** @var bool  */
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
