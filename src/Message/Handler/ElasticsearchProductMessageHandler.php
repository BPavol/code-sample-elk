<?php

declare(strict_types = 1);

namespace App\Message\Handler;

use App\Elasticsearch\EleasticsearchClient;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductTranslation;
use App\Message\ElasticsearchProductMessage;
use App\Repository\ProductRepository;
use App\Repository\ProductTranslationRepository;

final class ElasticsearchProductMessageHandler implements MessageHandlerInterface
{
    /** @var ProductRepository  */
    private ProductRepository $productRepository;

    /** @var ProductTranslationRepository  */
    private ProductTranslationRepository $productTranslationRepository;

    /** @var EleasticsearchClient  */
    private EleasticsearchClient $client;

    /**
     * Handle message and save Product entity to Elasticsearch
     *
     * @param ElasticsearchProductMessage $message
     */
    public function __invoke(ElasticsearchProductMessage $message)
    {
        if ($message->isForDelete()) {
            $this->deleteProduct($message->getId());
        }

        $product = $this->productRepository->find($message->getId());
        assert($product instanceof Product);

        $body = [
            'title' => $product->getTitle(),
            'category_id' => null,
            'category_title' => null,
            'short_description' => $product->getShortDescription(),
            'description' => $product->getDescription(),
            'active' => $product->isActive(),
            'price' => $product->getPrice(),
            'translations' => []
        ];
        $mainCategory = $product->getCategories()->first();
        if ($mainCategory !== null) {
            assert($mainCategory instanceof ProductCategory);
            $body['category_id'] = $mainCategory->getCategory()->getId();
            $body['category_title'] = $mainCategory->getCategory()->getTitle();
        }

        $translations = $this->productTranslationRepository->findBy([
            'product' => $product
        ]);

        $translationsPair = [];
        foreach ($translations as $translation) {
            assert($translation instanceof ProductTranslation);
            $translationsPair[$translation->getLanguage()] = $translation->getTranslation();
        }
        $body['translations'] = $translationsPair;

        $this->client->index(
            $product->getId(),
            [
                'body' => $body
            ]
        );
    }

    private function deleteProduct(int $productId): void
    {
        $this->client->delete($productId);
    }
}
