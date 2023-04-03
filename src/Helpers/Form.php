<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;

class Form implements Arrayable
{
    /** @var Input[] */
    protected array $fields = [];

    protected array $data = [];

    public static function make()
    {
        return new static();
    }

    public function fields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function toArray()
    {
        return [
            'schema' => $this->fields,
            'data' => collect($this->fields)
                ->mapWithKeys(fn (Input $input) => $input->toData())
                ->merge($this->data)
                ->toArray(),
        ];
    }
}
