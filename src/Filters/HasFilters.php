<?php

namespace Performing\View\Filters;

trait HasFilters
{
    protected $filters = [];

    public function scopeWithFilter($query, $filterType)
    {
        $this->filters[] = $filterType;
    }

    public function getFilters()
    {
        return $this->filters;
    }
}
