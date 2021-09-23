<?php

declare(strict_types = 1);

namespace App\Constraint;

use App\Constraint\Validator\ProductValidator;

final class ProductConstraint implements ConstraintInterface
{
    /**
     * @inheritDoc
     */
    public function validatedBy()
    {
        return ProductValidator::class;
    }
}
