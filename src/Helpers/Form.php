<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

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
