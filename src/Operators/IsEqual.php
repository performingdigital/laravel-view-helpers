<?php

namespace Performing\View\Operators;

class IsEqual extends Operator
{
    public function key(): string
    {
        return 'is_equal';
    }

    public function label(): string
    {
        return __('È uguale a...');
    }

    public function toSql(): string
    {
        return '=';
    }
}
