<?php

namespace App\Controller\API;

use App\Cache\CacheInterface;
use App\Cache\ItemInterface;
use App\Entity\Category;
use App\Message\ElasticsearchProductMessage;
use App\Message\MessageBusInterface;
use App\Repository\CategoryRepository;

final class CategoryController
{
    private CacheInterface $cache;
    private CategoryRepository $repository;
    private MessageBusInterface $bus;

    /**
     * Get whole category tree with base information
     */
    public function index()
    {
        $key = 'category_controller_index';
        return $this->cache->get($key, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            $item->tag('category');

            return $this->repository->findBy(['active' => true]);
        });
    }

    /**
     * Get all childs with base information by parent category id
     */
    public function getChilds(int $parentId)
    {
        $key = sprintf('category_controller_get_childs_%s', $parentId);
        return $this->cache->get($key, function (ItemInterface $item) use ($parentId) {
            $item->expiresAfter(3600);
            $item->tag('category');

            return $this->repository->findBy([
                'parent_id' => $parentId
            ]);
        });
    }

    /**
     * Get category details by category id
     */
    public function view(int $id)
    {
        $key = sprintf('category_controller_view_%s', $id);
        return $this->cache->get($key, function (ItemInterface $item) use ($id) {
            $item->expiresAfter(3600);
            $item->tag('category');

            return $this->repository->find($id);
        });
    }

    /**
     * Create new category
     */
    public function add()
    {

    }

    /**
     * Update existing category and dispatch Elasticsearch
     * reindex of all containing products
     *
     * @param Category $category
     */
    public function edit(Category $category)
    {
        $this->cache->invalidateTags(['category']);
        // Flush entity
        // Loop through all products in category and reindex them in Elasticsearch asynchronously
        $this->bus->dispatch(new ElasticsearchProductMessage(/*$productId*/));
    }

    /**
     * Delete entry only if didn't contains any product
     *
     * @param Category $category
     */
    public function delete(Category $category)
    {
        $this->cache->invalidateTags(['category']);
    }
}
