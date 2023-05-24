<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;

abstract class Helper implements Arrayable
{
    protected array $data = [];

    public function __call(string $name, array $args)
    {
        $this->data[$name] = $args[0];

        return $this;
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function toArray()
    {
        return $this->data;
    }
}
