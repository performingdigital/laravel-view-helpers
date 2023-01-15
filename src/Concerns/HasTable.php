<?php

namespace Performing\View\Concerns;

use Performing\View\Helpers\Table;

trait HasTable
{
    protected array $table = [];

    public function table($callback)
    {
        $this->table = $callback(Table::make())->toArray();

        $this->data['table'] = $this->table;

        return $this;
    }
}
