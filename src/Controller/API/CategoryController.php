<?php

declare(strict_types = 1);

namespace App\Controller\API;

use App\Cache\CacheInterface;
use App\Cache\ItemInterface;
use App\Entity\Category;
use App\Http\JsonResponse;
use App\Message\ElasticsearchProductMessage;
use App\Message\MessageBusInterface;
use App\Repository\CategoryRepository;

final class CategoryController
{
    /** @var CacheInterface  */
    private CacheInterface $cache;

    /** @var CategoryRepository  */
    private CategoryRepository $categoryRepository;

    /** @var MessageBusInterface  */
    private MessageBusInterface $bus;

    /**
     * Get whole category tree with base information
     */
    public function index(): JsonResponse
    {
        $key = 'category_controller_index';
        return new JsonResponse(
                $this->cache->get($key, function (ItemInterface $item) {
                $item->expiresAfter(3600);
                $item->tag('category');

                return $this->categoryRepository->findBy(['active' => true]);
            })
        );
    }

    /**
     * Get all childs with base information by parent category id
     */
    public function getChilds(int $parentId): JsonResponse
    {
        $key = sprintf('category_controller_get_childs_%s', $parentId);
        return new JsonResponse(
            $this->cache->get($key, function (ItemInterface $item) use ($parentId) {
                $item->expiresAfter(3600);
                $item->tag('category');

                return $this->categoryRepository->findBy([
                    'parent_id' => $parentId
                ]);
            })
        );
    }

    /**
     * Get category details by category id
     */
    public function view(int $id): JsonResponse
    {
        $key = sprintf('category_controller_view_%s', $id);
        return new JsonResponse(
            $this->cache->get($key, function (ItemInterface $item) use ($id) {
                $item->expiresAfter(3600);
                $item->tag('category');

                return $this->categoryRepository->find($id);
            })
        );
    }

    /**
     * Create new category
     */
    public function add()
    {
        return new JsonResponse();
    }

    /**
     * Update existing category and dispatch Elasticsearch
     * reindex of all containing products
     *
     * @param Category $category
     */
    public function edit(Category $category): JsonResponse
    {
        $this->cache->invalidateTags(['category']);

        // Flush entity
        // Loop through all products in category and reindex them in Elasticsearch asynchronously
        $productIds = [];
        foreach ($productIds as $productId) {
            $this->bus->dispatch(new ElasticsearchProductMessage($productId));
        }

        return new JsonResponse();
    }

    /**
     * Delete entry only if didn't contains any product
     *
     * @param Category $category
     */
    public function delete(Category $category): JsonResponse
    {
        $this->cache->invalidateTags(['category']);

        return new JsonResponse();
    }
}
