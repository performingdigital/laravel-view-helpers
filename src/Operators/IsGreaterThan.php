<?php

namespace Performing\View\Operators;

class IsGreaterThan extends Operator
{
    public function key(): string
    {
        return 'is_greater_than';
    }

    public function label(): string
    {
        return __('È maggiore di...');
    }

    public function toSql(): string
    {
        return '>';
    }
}
