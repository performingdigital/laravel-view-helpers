<?php

namespace Performing\View\Operators;

use PHPUnit\Framework\Constraint\IsEmpty;

class OperatorFactory
{
    public static function getOperator(string $name)
    {
        return match ($name) {
            'is_equals' => new IsEquals,
            'is_not_equals' => new IsNotEquals,
            'is_greater_than' => new IsGreaterThan,
            'is_less_than' => new IsLessThan,
            'starts_with' => new StartsWith,
            'contains' => new Contains,
            'ends_with' => new EndsWith,
            'is_empty' => new IsEmpty,
            default => null,
        };
    }
}
