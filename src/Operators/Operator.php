<?php

namespace Performing\View\Operators;

use Illuminate\Contracts\Support\Arrayable;

abstract class Operator implements Arrayable
{
    abstract public function key(): string;

    abstract public function label(): string;

    abstract public function toSql(): string;

    public function standalone()
    {
        return false;
    }

    public function transform($value): ?string
    {
        return $value;
    }

    public function toArray()
    {
        return [
            'key' => $this->key(),
            'label' => $this->label(),
            'standalone' => $this->standalone(),
        ];
    }
}
