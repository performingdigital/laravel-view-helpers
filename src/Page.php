<?php

namespace Performing\View;

use Illuminate\Contracts\Support\Arrayable;
use Inertia\Inertia;
use Performing\View\Concerns\HasActions;
use Performing\View\Concerns\HasForm;
use Performing\View\Concerns\HasTable;
use Performing\View\Concerns\Mergeable;
use Performing\View\Helpers\Table;

class Page implements Arrayable
{
    use Mergeable;

    public function __construct(
        protected string $title,
        protected array $data = []
    ) {}

    public static function make(string $title)
    {
        return new static($title);
    }

    public function toArray()
    {
        $this->data['title'] = $this->title;

        return $this->data;
    }

    public function render($component)
    {
        $data = [];

        foreach ($this->toArray() as $key => $value) {
            $data[$key] = fn () => $value;
        }

        return Inertia::render($component, $data);
    }

    public function __call(string $name, array $args)
    {
        if (! method_exists($this, $name)) {

            if (is_callable($args[0])) {
                $this->data[$name] = call_user_func($args[0]);
            } else {
                $this->data[$name] = $args[0];
            }

            return $this;
        }
    }
}
