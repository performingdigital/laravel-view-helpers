<?php

namespace Performing\View\Operators;

class IsNotEmpty extends Operator
{
    public function key(): string
    {
        return 'is_not_empty';
    }

    public function standalone()
    {
        return true;
    }

    public function label(): string
    {
        return __('Non è vuoto...');
    }

    public function toSql(): string
    {
        return '<>';
    }
}
