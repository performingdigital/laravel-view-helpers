<?php

namespace Performing\View\Factories;

use Performing\View\Operators\Contains;
use Performing\View\Operators\EndsWith;
use Performing\View\Operators\IsEmpty;
use Performing\View\Operators\IsEqual;
use Performing\View\Operators\IsGreaterThan;
use Performing\View\Operators\IsLessThan;
use Performing\View\Operators\IsNotEmpty;
use Performing\View\Operators\IsNotEqual;
use Performing\View\Operators\IsOneOfAny;
use Performing\View\Operators\NotContains;
use Performing\View\Operators\StartsWith;

class OperatorFactory
{
    public static function getOperator(string $name)
    {
        return match ($name) {
            'is_equal' => new IsEqual(),
            'is_not_equal' => new IsNotEqual(),
            'is_greater_than' => new IsGreaterThan(),
            'is_less_than' => new IsLessThan(),
            'starts_with' => new StartsWith(),
            'contains' => new Contains(),
            'not_contains' => new NotContains(),
            'ends_with' => new EndsWith(),
            'is_empty' => new IsEmpty(),
            'is_not_empty' => new IsNotEmpty(),
            'is_one_of_any' => new IsOneOfAny(),
            default => null,
        };
    }
}
