<?php

namespace App\Constraint;

use App\Constraint\Validator\ProductValidator;

class ProductConstraint implements ConstraintInterface
{
    /**
     * @inheritDoc
     */
    public function validatedBy()
    {
        return ProductValidator::class;
    }
}
