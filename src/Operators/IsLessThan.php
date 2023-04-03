<?php

namespace Performing\View\Operators;

class IsLessThan extends Operator
{
    public function key(): string
    {
        return 'is_less_than';
    }

    public function label(): string
    {
        return __('È minore di...');
    }

    public function toSql(): string
    {
        return '<';
    }
}
