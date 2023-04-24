<?php

namespace Performing\View\Helpers;

use Illuminate\Support\Str;

class TableColumn extends Helper
{
    protected array $data = ['type' => 'text'];

    public function __construct(string $title, ?string $key = null)
    {
        $this->data['title'] = $title;
        $this->data['key'] = $key ?? Str::of($title)->lower()->slug('_')->toString();
    }

    public static function make(string $title, ?string $key = null)
    {
        return new static($title, $key);
    }

    public function sortable()
    {
        $this->data['sortable'] = true;

        return $this;
    }

    public function component(string $type)
    {
        $this->data['type'] = $type;

        return $this;
    }
}
