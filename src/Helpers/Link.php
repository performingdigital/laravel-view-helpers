<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class Link implements Arrayable
{
    public function __construct(
        protected string $label,
        protected string $route
    ) {
    }

    public static function make($label, $route)
    {
        return new static($label, $route);
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'name' => $this->route
        ];
    }
}
