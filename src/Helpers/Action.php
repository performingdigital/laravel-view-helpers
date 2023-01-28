<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Performing\View\Concerns\Mergeable;

class Action implements Arrayable
{
    use Mergeable;

    protected $data = [];

    public static function make(string $label, string $url): Action
    {
        $action = new Action();

        return $action->merge(['label' => $label, 'url' => $url]);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
