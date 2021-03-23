<?php

namespace App\Message\Handler;

use App\Elasticsearch\EleasticsearchClient;
use App\Message\ElasticsearchProductMessage;
use App\Repository\ProductRepository;

class ElasticsearchProductMessageHandler implements MessageHandlerInterface
{
    private ProductRepository $repository;
    private EleasticsearchClient $client;

    /**
     * Handle message and save Product entity to Elasticsearch
     *
     * @param ElasticsearchProductMessage $message
     */
    public function __invoke(ElasticsearchProductMessage $message)
    {
        $product = $this->repository->find($message->getId());

        $this->client->index(
            $product->getId(),
            [
                'body' => [
                     /*
                     *'title' => $product->getTitle(),
                     * 'category_id' => $product->getCategories()[0]?->getId(),
                     * 'category_title' => $product->getCategory()[0]?->getTitle(),
                     * 'short_description' => $product->getShortDescription(),
                     * 'description' => $product->getDescription(),
                     * 'active' => $product->getActive(),
                     * 'price' => $product->getPrice()
                     * 'translations' => // Loop through all translations and concatenate them
                     */
                ]
            ]
        );
    }
}
