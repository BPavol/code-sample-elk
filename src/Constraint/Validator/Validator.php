<?php

declare(strict_types = 1);

namespace App\Constraint\Validator;

use App\Constraint\ConstraintInterface;
use App\Constraint\Context;

final class Validator extends AbstractValidator
{
    /** @var Context  */
    protected Context $context;

    /**
     * @inheritDoc
     */
    public function validate(ConstraintInterface $constraint, $value): void
    {
        $validatorClass = $constraint->validatedBy();
        $validator = new $validatorClass($this->context);
        $validator->validate($constraint, $value);
    }
}
