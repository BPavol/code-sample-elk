<?php

declare(strict_types = 1);

namespace App\Constraint\Validator;

use App\Constraint\Context;

abstract class AbstractValidator implements ValidatorInterface
{
    /** @var Context  */
    protected Context $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @inheritDoc
     */
    public function getContext(): Context
    {
        return $this->context;
    }
}
