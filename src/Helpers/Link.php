<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Performing\View\Concerns\Mergeable;

class Link implements Arrayable
{
    use Mergeable;

    protected $data = [];

    public static function make(string $label, string $href): self
    {
        $action = new static();

        return $action->merge(['label' => $label, 'href' => $href]);
    }

    public function confirm()
    {
        $this->data['confirm'] = true;

        return $this;
    }

    public function __call(string $name, array $args)
    {
        if (str_starts_with($name, 'as')) {
            $this->data['method'] = strtolower(str_replace('as', '', $name));

            return $this;
        }

        $this->data[$name] = $args[0];

        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
