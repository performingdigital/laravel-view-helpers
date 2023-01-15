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
        protected ?string $key = null,
    ) {
        $this->key ??= Str::of($title)->lower()->slug()->toString();
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

    public function component(ColumnType $type)
    {
        $this->type = $type->value;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'key' => $this->key,
            'sortable' => $this->sortable,
            'type' => $this->type ?? ColumnType::Text->value,
        ];
    }
}
