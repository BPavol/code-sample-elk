<?php

namespace App\Constraint\Validator;

use App\Constraint\Context;

abstract class AbstractValidator implements ValidatorInterface
{
    protected Context $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @inheritDoc
     */
    public function getContext()
    {
        return $this->context;
    }
}
