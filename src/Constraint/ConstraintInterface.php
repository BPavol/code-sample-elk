<?php

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
