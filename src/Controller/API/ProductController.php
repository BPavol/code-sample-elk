<?php

declare(strict_types = 1);

namespace App\Controller\API;

use App\Cache\CacheInterface;
use App\Cache\ItemInterface;
use App\Constraint\ProductConstraint;
use App\Constraint\Validator\Validator;
use App\Elasticsearch\EleasticsearchClient;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Http\JsonResponse;
use App\Message\ElasticsearchProductMessage;
use App\Message\MessageBusInterface;
use App\Repository\ProductRepository;

final class ProductController
{
    /** @var CacheInterface  */
    private CacheInterface $cache;

    /** @var EleasticsearchClient  */
    private EleasticsearchClient $client;

    /** @var MessageBusInterface  */
    private MessageBusInterface $bus;

    /** @var Validator  */
    private Validator $validator;

    /** @var ProductRepository  */
    private ProductRepository $productRepository;

    /**
     * Search product in all categories and return base information.
     * Use cache invalidated by tag pn product deletion or update.
     *
     * @param string|null $term
     * @param int $page
     */
    public function index(?string $term, int $page): JsonResponse
    {
        $key = sprintf('product_controller_index_%s_%d', $term, $page);
        return new JsonResponse(
            $this->cache->get($key, function (ItemInterface $item) use ($term, $page) {
                $item->expiresAfter(3600);
                $item->tag('product');

                if ($term === null) {
                    return $this->productRepository->findBy(['active' => true],10, ($page-1)*10);
                }

                // Product ids in array
                $elkResults = $this->client->query($term, 10, ($page-1)*10);
                return $this->productRepository->findBy([
                    'id' => $elkResults,
                ]);
            })
        );
    }

    /**
     * Return all products in category.
     *
     * @param Category $category
     */
    public function getByCategory(Category $category, int $page): JsonResponse
    {
        $key = sprintf('product_controller_get_by_category_%d_%d', $category->getId(), $page);
        return new JsonResponse(
            $this->cache->get($key, function (ItemInterface $item) use ($category, $page) {
                $item->expiresAfter(3600);
                $item->tag('product');

                return $this->productRepository->findBy([
                    'category_id' => $category,
                ], 10, ($page-1)*10);
            })
        );
    }

    /**
     * Get product details by product id
     */
    public function view(int $id): JsonResponse
    {
        $key = sprintf('product_controller_view_%d', $id);
        return new JsonResponse(
            $this->cache->get($key, function (ItemInterface $item) use ($id) {
                $item->expiresAfter(3600);
                $item->tag('product');

                return $this->productRepository->find($id);
            })
        );
    }

    /**
     * Create new product and dispatch message
     * for insertion to Elasticsearch
     */
    public function add(): JsonResponse
    {
        $this->cache->invalidateTags(['product']);

        $product = new Product();
        $this->validator->validate(new ProductConstraint(), $product);
        $validatorContext = $this->validator->getContext();
        $errors = $validatorContext->getErrors();
        if ($errors) {
            return new JsonResponse(['errors' => $errors], 500);
        }

        // Flush entity
        $this->bus->dispatch(new ElasticsearchProductMessage($product->getId()));
        return new JsonResponse();
    }

    /**
     * Update existing product and dispatch message
     * for index update in Elasticsearch
     */
    public function edit(Product $product): JsonResponse
    {
        $this->validator->validate(new ProductConstraint(), $product);
        $validatorContext = $this->validator->getContext();
        $errors = $validatorContext->getErrors();
        if ($errors) {
            return new JsonResponse(['errors' => $errors], 500);
        }

        $this->cache->invalidateTags(['product']);

        // Flush entity
        $this->bus->dispatch(new ElasticsearchProductMessage($product->getId()));
        return new JsonResponse();
    }

    /**
     * Delete entry in database and dispatch message
     * for product deletion.
     *
     * @param int $id
     */
    public function delete(Product $product): JsonResponse
    {
        // Delete product

        $this->cache->invalidateTags(['product']);

        $this->bus->dispatch(new ElasticsearchProductMessage($product->getId(), true));
        return new JsonResponse();
    }

    /**
     * Delete image from product
     *
     * @param Product $product
     * @param ProductImage $productImage
     */
    public function deleteImage(Product $product, ProductImage $productImage): JsonResponse
    {
        $this->cache->invalidateTags(['product']);
        // Delete image

        return new JsonResponse();
    }

    /**
     * Add image to product
     */
    public function addImage(Product $product): JsonResponse
    {
        $this->cache->invalidateTags(['product']);
        // Upload image
        // Add image to Product entity
        $this->validator->validate(new ProductConstraint(), $product);
        $validatorContext = $this->validator->getContext();
        $errors = $validatorContext->getErrors();
        if ($errors) {
            return new JsonResponse(['errors' => $errors], 500);
        }

        // Flush entity

        return new JsonResponse();
    }
}
