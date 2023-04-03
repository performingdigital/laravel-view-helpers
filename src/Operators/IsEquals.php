<?php

namespace Performing\View\Operators;

class IsEquals extends Operator
{
    public function key(): string
    {
        return 'is_equals';
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
