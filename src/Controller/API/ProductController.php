<?php

namespace App\Controller\API;

use App\Cache\CacheInterface;
use App\Cache\ItemInterface;
use App\Constraint\ProductConstraint;
use App\Constraint\Validator\Validator;
use App\Elasticsearch\EleasticsearchClient;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Message\ElasticsearchProductMessage;
use App\Message\MessageBusInterface;
use App\Repository\ProductRepository;

final class ProductController
{
    private CacheInterface $cache;
    private EleasticsearchClient $client;
    private MessageBusInterface $bus;
    private Validator $validator;
    private ProductRepository $repository;

    /**
     * Search product in all categories and return base information.
     * Use cache invalidated by tag pn product deletion or update.
     *
     * @param string|null $term
     * @param int $page
     */
    public function index(?string $term, int $page)
    {
        $key = sprintf('product_controller_index_%s_%d', $term, $page);
        return $this->cache->get($key, function (ItemInterface $item) use ($term, $page) {
            $item->expiresAfter(3600);
            $item->tag('product');

            if ($term === null) {
                return $this->repository->findBy(['active' => true],10, ($page-1)*10);
            }

            // Product ids in array
            $elkResults = $this->client->query($term, 10, ($page-1)*10);
            return $this->repository->findBy([
                'id' => $elkResults,
            ]);
        });
    }

    /**
     * Return all products in category.
     *
     * @param Category $category
     */
    public function getByCategory(Category $category, int $page)
    {
        $key = sprintf('product_controller_get_by_category_%d_%d', $category->getId(), $page);
        return $this->cache->get($key, function (ItemInterface $item) use ($category, $page) {
            $item->expiresAfter(3600);
            $item->tag('product');

            return $this->repository->findBy([
                'category_id' => $category,
            ], 10, ($page-1)*10);
        });
    }

    /**
     * Get product details by product id
     */
    public function view(int $id)
    {
        $key = sprintf('product_controller_view_%d', $id);
        return $this->cache->get($key, function (ItemInterface $item) use ($id) {
            $item->expiresAfter(3600);
            $item->tag('product');

            return $this->repository->find($id);
        });
    }

    /**
     * Create new product and dispatch message
     * for insertion to Elasticsearch
     */
    public function add()
    {
        $this->cache->invalidateTags(['product']);

        $product = new Product();
        $this->validator->validate(new ProductConstraint(), $product);
        $validatorContext = $this->validator->getContext();
        $errors = $validatorContext->getErrors();
        if ($errors) {
            return $errors;
        }

        // Flush entity
        $this->bus->dispatch(new ElasticsearchProductMessage($product->getId()));
    }

    /**
     * Update existing product and dispatch message
     * for index update in Elasticsearch
     */
    public function edit(int $id)
    {
        $this->cache->invalidateTags(['product']);

        $this->validator->validate(new ProductConstraint(), $product);
        $validatorContext = $this->validator->getContext();
        $errors = $validatorContext->getErrors();
        if ($errors) {
            return $errors;
        }

        // Flush entity
        $this->bus->dispatch(new ElasticsearchProductMessage($id));
    }

    /**
     * Delete entry in database and dispatch message
     * for product deletion.
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->cache->invalidateTags(['product']);

        $this->bus->dispatch(new ElasticsearchProductMessage($id, true));
    }

    /**
     * Delete image from product
     *
     * @param Product $product
     * @param ProductImage $productImage
     */
    public function deleteImage(Product $product, ProductImage $productImage)
    {
        $this->cache->invalidateTags(['product']);
        // Delete image
    }

    /**
     * Add image to product
     */
    public function addImage(Product $product)
    {
        $this->cache->invalidateTags(['product']);
        // Upload image
        // Add image to Product entity
        $this->validator->validate(new ProductConstraint(), $product);
        $validatorContext = $this->validator->getContext();
        $errors = $validatorContext->getErrors();
        if ($errors) {
            return $errors;
        }

        // Flush entity
    }
}
