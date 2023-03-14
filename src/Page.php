<?php

namespace Performing\View;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Macroable;
use Inertia\Inertia;
use Performing\View\Concerns\HasActions;
use Performing\View\Concerns\HasForm;
use Performing\View\Concerns\HasTable;
use Performing\View\Concerns\Mergeable;

class Page implements Arrayable
{
    use Macroable;
    use Mergeable;
    use HasForm;
    use HasTable;
    use HasActions;

    protected array $data = [];

    public function __construct(
        protected string $title
    ) {
        $this->data['title'] = $this->title;
    }

    public static function make(string $title)
    {
        return new static($title);
    }

    public function __call(string $name, array $args)
    {
        if (str_starts_with($name, 'table') && ! method_exists($this, $name)) {
            $callback = $args[0];
            if (! is_callable($callback)) {
                throw new \Exception('Table helper expects callable as first argument');
            }
            $this->data[strtolower(str_replace('table', '', $name))] = $callback(Table::make())->toArray();

            return $this;
        }

        if (! method_exists($this, $name)) {
            $this->data[$name] = $args[0];

            return $this;
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    public function render($component)
    {
        $data = [];

        foreach ($this->data as $key => $value) {
            $data[$key] = fn () => $value;
        }

        return Inertia::render($component, $data);
    }
}
