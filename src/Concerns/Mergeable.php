<?php

namespace Performing\View\Concerns;

trait Mergeable
{
    public function merge(array $data): self
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }
}
