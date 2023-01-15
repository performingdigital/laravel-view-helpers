<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;

class Form implements Arrayable
{
    protected array $fields = [];

    public static function make()
    {
        return new static();
    }

    public function toArray()
    {
        return $this->fields;
    }
}
