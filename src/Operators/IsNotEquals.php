<?php

namespace Performing\View\Operators;

class IsNotEquals extends Operator
{
    public function key(): string
    {
        return 'is_not_equals';
    }

    public function label(): string
    {
        return __('Non è uguale a...');
    }

    public function toSql(): string
    {
        return '<>';
    }
}
