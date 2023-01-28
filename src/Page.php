<?php

namespace Performing\View;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Traits\Macroable;
use Performing\View\Concerns\HasActions;
use Performing\View\Concerns\HasForm;
use Performing\View\Concerns\HasTable;
use Illuminate\Contracts\Support\Arrayable;
use Inertia\Inertia;
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

    public function toArray()
    {
        return $this->data;
    }

    public function render($component)
    {
        return Inertia::render($component, $this->toArray());
    }
}
