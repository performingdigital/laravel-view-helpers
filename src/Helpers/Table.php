<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;

class Table implements Arrayable
{
    protected array $columns = [];

    protected array $filters = [];

    protected $rows = null;

    protected ?string $resource = null;

    protected array $query = [];

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        if (config('view-helpers.table.filters')) {
            array_merge($this->filters, config('view-helpers.table.default_filters'));
        }

        $this->query = config('view-helpers.table.default_query');
    }

    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function filters(array $filters)
    {
        $this->filters = [...$this->filters, ...$filters];

        return $this;
    }

    public function rows($data, ?string $class = null)
    {
        $this->rows = $data;
        $this->resource = $class;

        return $this;
    }

    public function toArray()
    {
        collect($this->filters)->map(function ($filter) {
            if (! empty(request()->input('filters.'.$filter->key))) {
                $filter->apply($this->rows, request()->input('filters.'.$filter->key));
            }
        });

        $this->rows = $this->rows
            ->paginate(request('filters.per_page', 15))
            ->withQueryString();

        if (! is_null($this->resource)) {
            $class = $this->resource;
            $this->rows->through(fn ($item) => $class::make($item));
        }

        return [
            'columns' => $this->columns,
            'rows' => $this->rows,
            'filters' => $this->filters,
            'query' => collect($this->filters)
                ->mapWithKeys(fn ($filter) => [
                    $filter->key => request()->input('filters.'.$filter->key),
                ])
                ->merge($this->query)
                ->toArray(),
        ];
    }
}
