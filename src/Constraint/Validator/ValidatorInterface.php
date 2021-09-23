<?php

declare(strict_types = 1);

namespace App\Constraint\Validator;

use App\Constraint\ConstraintInterface;
use App\Constraint\Context;

interface ValidatorInterface
{
    /**
     * Validate and assign violations to context
     *
     * @param ConstraintInterface $constraint
     * @param $value
     * @return mixed
     */
    public function validate(ConstraintInterface $constraint, $value): void;

    /**
     * Return validation context
     *
     * @return Context
     */
    public function getContext(): Context;
}
