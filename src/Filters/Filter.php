<?php

namespace Performing\View\Filters;

use Illuminate\Contracts\Support\Arrayable;

abstract class Filter implements Arrayable, Filterable
{
    public function key(): string
    {
        return str($this->title())->slug('_')->toString();
    }

    public function hint(): ?string
    {
        return null;
    }

    public function placeholder(): ?string
    {
        return null;
    }

    public function type(): string
    {
        return 'text';
    }

    public function props(): array
    {
        $props = [];
        $reflection = new \ReflectionObject($this);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(FilterProp::class);

            if (count($attributes) > 0) {
                $props[$method->getName()] = $this->{$method->getName()}();
            }
        }

        return $props;
    }

    public function toArray()
    {
        return [
            'key' => $this->key(),
            'label' => $this->title(),
            'title' => $this->title(),
            'hint' => $this->hint(),
            'type' => $this->type(),
            'props' => $this->props(),
            'operators' => collect($this->operators())
                ->mapWithKeys(fn ($op) => [ $op->key() => $op->label() ])
                ->toArray(),
        ];
    }
}
