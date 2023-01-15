<?php

namespace Performing\View;

use Illuminate\Http\Resources\Json\JsonResource;
use Performing\View\Concerns\HasActions;
use Performing\View\Concerns\HasForm;
use Performing\View\Concerns\HasTable;
use Illuminate\Contracts\Support\Arrayable;
use Inertia\Inertia;
use Performing\View\Tests\FakeApp\Http\Resources\PostResource;

class Page implements Arrayable
{
    use HasForm;
    use HasTable;
    use HasActions;

    protected array $data = [];

    public function __construct(
        protected string $title
    ) {
    }

    public static function make(string $title)
    {
        return new static($title);
    }

    public function toArrayRecursive($object): array|string|null
    {
        if ($object instanceof JsonResource) {
            $object = $object->toArray(null) ?? [];
        } elseif ($object instanceof Arrayable) {
            $object = $object->toArray() ?? [];
        }

        if (is_iterable($object)) {
            foreach ($object as $key => $value) {
                $object[$key] = $this->toArrayRecursive($object[$key]);
            }
        }

        return $object;
    }

    public function toArray($part = null)
    {
        $this->data['title'] = $this->title;
        // return $this->toArrayRecursive($this->data);
        return $this->data;
    }

    public function merge($data)
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function render($component)
    {
        return Inertia::render($component, $this->toArray());
    }
}
