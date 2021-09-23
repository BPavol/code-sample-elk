<?php

declare(strict_types = 1);

namespace App\Entity;

/**
 * Product and category relation
 */
final class ProductCategory
{
    /** @var Product  */
    private Product $product;

    /** @var Category  */
    private Category $category;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
}
