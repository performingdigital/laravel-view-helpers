<?php

namespace Performing\View\Filters;

use Illuminate\Contracts\Support\Arrayable;

abstract class FilterType implements Arrayable, FilterableType
{
    use FilterScope;

    public function name(): string
    {
        return str($this->label())->slug('_')->toString();
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
            'name' => $this->name(),
            'label' => $this->label(),
            'props' => $this->props(),
            'operators' => $this->operators()
        ];
    }
}
