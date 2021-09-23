<?php

declare(strict_types = 1);

namespace App\Constraint;

interface ConstraintInterface
{
    /**
     * Class name of constraint validator
     *
     * @return string
     */
    public function validatedBy();
}
