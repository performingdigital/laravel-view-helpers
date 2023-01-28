<?php

namespace Performing\View\Concerns;

trait HasActions
{
    public function actions(array $actions): static
    {
        $this->data['actions'] = $actions;

        return $this;
    }
}
