<?php

namespace Performing\View\Helpers;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class Filter implements Arrayable
{
    protected string $type;

    protected string $placeholder = '';

    protected $options;

    protected ?Closure $callback = null;

    public function __construct(
        protected string $label,
        public ?string $key = null,
    ) {
        $this->key ??= Str::of($label)->lower()->slug()->toString();
    }

    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function placeholder(string $placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function options($options)
    {
        $this->options = $options;

        return $this;
    }

    public function on($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    public function apply($query, $value)
    {
        if (is_callable($this->callback)) {
            $func = $this->callback;
            $func($query, $value);
        }
    }

    public static function make(string $label, ?string $key = null)
    {
        return new static($label, $key);
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'key' => $this->key,
            'type' => $this->type,
            'placeholder' => $this->placeholder,
            'options' => $this->options,
        ];
    }
}
