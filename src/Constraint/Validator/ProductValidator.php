<?php

namespace App\Constraint\Validator;

use App\Constraint\ConstraintInterface;
use App\Entity\Product;

final class ProductValidator extends AbstractValidator
{
    /**
     * @inheritDoc
     */
    public function validate(ConstraintInterface $constraint, $value)
    {
        if (!($value instanceof Product)) {
            throw new \Exception(sprintf('Constraint require Product entity, %s given', gettype($value)));
        }

        $this->validateImages();
        $this->validateCategory();
    }

    /**
     * Validate if product has less or equal than 3 images
     */
    public function validateImages()
    {

    }

    /**
     * Validate if product is in exactly one category
     */
    public function validateCategory()
    {

    }
}
