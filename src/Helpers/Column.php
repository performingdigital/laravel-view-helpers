<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class Column implements Arrayable
{
    protected bool $sortable = false;

    protected ?string $type = null;

    public function __construct(
        protected string $title,
        public ?string $key = null,
    ) {
        $this->key ??= Str::of($title)->lower()->slug('_')->toString();
    }

    public static function make(string $title, ?string $key = null)
    {
        return new static($title, $key);
    }

    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }

    public function component(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'key' => $this->key,
            'sortable' => $this->sortable,
            'type' => $this->type ?? 'text',
        ];
    }
}
