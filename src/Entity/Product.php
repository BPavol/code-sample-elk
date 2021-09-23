<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Collection\Collection;

final class Product
{
    /** @var int  */
    private int $id;

    /** @var string  */
    private string $title;

    /** @var string  */
    private string $shortDescription;

    /** @var string  */
    private string $description;

    /** @var float  */
    private float $price;

    /** @var bool  */
    private bool $active;

    /** @var Collection|ProductCategory[] */
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new Collection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return Collection|ProductCategory[]
     */
    public function getCategories(): Collection|array
    {
        return $this->categories;
    }

    /**
     * @param Collection|ProductCategory[] $categories
     */
    public function setCategories(Collection|array $categories): void
    {
        $this->categories = $categories;
    }
}
