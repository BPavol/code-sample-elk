<?php

declare(strict_types = 1);

namespace App\Constraint;

final class Context
{
    /** @var string[] */
    private array $errors;

    /**
     * Add error to list of errors in current context
     *
     * @param string $message
     */
    public function addError(string $message)
    {
        $this->errors[] = $message;
    }

    /**
     * Return all errors
     *
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
