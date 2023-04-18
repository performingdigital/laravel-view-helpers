<?php

namespace Performing\View\Operators;

class IsOneOfAny extends Operator
{
    public function key(): string
    {
        return 'is_one_of_any';
    }

    public function label(): string
    {
        return __('È uno tra...');
    }

    public function toSql(): string
    {
        return 'in';
    }
}
