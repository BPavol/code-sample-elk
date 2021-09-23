<?php

declare(strict_types = 1);

namespace App\Entity;

/**
 * Category with tree structure.
 */
final class Category
{
    /** @var int  */
    private int $id;

    /** @var string  */
    private string $title;

    /** @var Category|null  */
    private ?Category $root;

    /** @var Category  */
    private Category $parent;

    /**
     * Define tree structure of category.
     *
     * @var string
     */
    private string $treePath;

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
     * @return Category|null
     */
    public function getRoot(): ?Category
    {
        return $this->root;
    }

    /**
     * @param Category|null $root
     */
    public function setRoot(?Category $root): void
    {
        $this->root = $root;
    }

    /**
     * @return Category
     */
    public function getParent(): Category
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getTreePath(): string
    {
        return $this->treePath;
    }

    /**
     * @param string $treePath
     */
    public function setTreePath(string $treePath): void
    {
        $this->treePath = $treePath;
    }
}
