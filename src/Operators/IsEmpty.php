<?php

namespace Performing\View\Operators;

class IsEmpty extends Operator
{
    public function key(): string
    {
        return 'is_empty';
    }

    public function label(): string
    {
        return __('È vuoto...');
    }

    public function toSql(): string
    {
        return '=';
    }
}
