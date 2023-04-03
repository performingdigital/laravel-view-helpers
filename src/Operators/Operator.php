<?php

namespace Performing\View\Operators;

abstract class Operator
{
    abstract public function key(): string;

    abstract public function label(): string;

    abstract public function toSql(): string;

    public function transform($value): ?string
    {
        return $value;
    }
}
