<?php

namespace App\Constraint\Validator;

use App\Constraint\ConstraintInterface;
use App\Constraint\Context;

final class Validator extends AbstractValidator
{
    private Context $context;

    /**
     * @inheritDoc
     */
    public function validate(ConstraintInterface $constraint, $value)
    {
        $validatorClass = $constraint->validatedBy();
        $validator = new $validatorClass($this->context);
        $validator->validate($constraint, $value);
    }
}
