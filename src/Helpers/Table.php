<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;

class Table implements Arrayable
{
    protected array $columns = [];

    protected array $filters = [];

    protected array $sorters = [];

    protected $rows = null;

    protected ?string $resource = null;

    protected array $query = [];

    public function __construct()
    {
        if (config('view-helpers.table.filters')) {
            array_merge($this->filters, config('view-helpers.table.default_filters'));
        }

        $this->query = config('view-helpers.table.default_query');
    }

    public static function make()
    {
        return new static();
    }

    public function columns(array $columns)
    {
        $this->columns = collect($columns)->map->toArray()->toArray();

        return $this;
    }

    public function filters(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    public function sorters(array $sorters)
    {
        $this->sorters = array_merge($this->sorters, $sorters);

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
            if (! is_null(request()->input('filters.'.$filter->key))) {
                $filter->apply($this->rows, request()->input('filters.'.$filter->key));
            }
        });

        if (request()->has('sort')) {
            $column = str_replace('-', '', request()->get('sort'));
            $direction = str_starts_with(request()->get('sort'), '-') ? 'asc' : 'desc';
            if (array_key_exists($column, $this->sorters)) {
                $this->sorters[$column]($this->rows, $direction);
            } else {
                $this->rows->orderBy($column, $direction);
            }
        }

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
                ->merge(['per_page' => request('filters.per_page')], $this->query)
                ->toArray(),
        ];
    }
}
