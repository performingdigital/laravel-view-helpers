<?php

namespace Performing\View\Concerns;

trait HasForm
{
    protected array $schema = [];

    public function form($schema, $default = [])
    {
        $this->schema = $schema;

        $this->data['form'] = [
            'schema' => $this->schema,
            'data' => collect($this->schema)
                ->mapWithKeys(fn ($input) => $input->toData())
                ->merge($default)
        ];

        return $this;
    }
}
