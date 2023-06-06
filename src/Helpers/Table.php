<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Performing\View\Factories\OperatorFactory;

class Table implements Arrayable
{
    protected array $columns = [];

    protected array $filters = [];

    protected array $sorters = [];

    protected $rows = null;

    protected ?string $resource = null;

    protected array $query = ['par_page' => 10];

    protected string $filtersKey = 'filters';

    public function __construct()
    {
        $this->query = config('view-helpers.table.default_query');
    }

    public static function make()
    {
        return new static();
    }

    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function filters(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    public function filtersKey(string $key)
    {
        $this->filtersKey = $key;

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
        $this->applyFilters();
        $this->applySorting();
        $this->applyPaginate();

        return [
            'columns' => $this->columns,
            'rows' => $this->rows,
            'filters' => $this->filters,
            'query' => $this->getQuery(),
        ];
    }

    protected function applyFilters()
    {
        collect($this->rows->getModel()->getFilters())->each(function ($filter) {
            $this->applyFilter($filter);
        });

        collect($this->filters)->each(function ($filter) {
            $this->applyFilter($filter);
        });
    }

    public function applyFilter($filter)
    {
        $params = request()->input($this->filtersKey . '.' . $filter->name());

        $value = is_array($params)
            ? $params['value'] ?? null
            : $params;

        $operator = is_array($params)
            ? $params['operator'] ?? null
            : null;

        if ($operator) {
            $filter->withOperator($operator);
        }

        if ($filter->hasStandaloneOperator()) {
            $filter->apply($this->rows);
        } elseif (! empty($value)) {
            $filter->withValue($value)->apply($this->rows);
        }
    }

    protected function applyPaginate()
    {
        $this->rows = $this->rows
            ->paginate($this->getPerPage(), ['*'], $this->filtersKey . '_page')
            ->withQueryString();

        if (! is_null($this->resource)) {
            $class = $this->resource;
            $this->rows->through(function ($item) use ($class) {
                $data = $class::make($item)->resolve();
                foreach ($this->columns as $column) {
                    if ($column->format instanceof \Closure) {
                        $closure = \Closure::bind($column->format, $item);
                        $data[$column->get('key')] = $closure($item, $column);
                    }
                }

                return $data;
            });
        }
    }

    protected function applySorting()
    {
        if (request()->has($this->filtersKey . '_sort')) {
            $column = str_replace('-', '', request()->input($this->filtersKey . '_sort'));
            $direction = str_starts_with(request()->input($this->filtersKey . '_sort'), '-') ? 'asc' : 'desc';
            if (array_key_exists($column, $this->sorters)) {
                $this->sorters[$column]($this->rows, $direction);
            } else {
                $this->rows->orderBy($column, $direction);
            }
        }
    }

    protected function getQuery(): array
    {
        return collect($this->filters)
            ->mapWithKeys(fn ($filter) => [
                $filter->name() => request()->input("$this->filtersKey." . $filter->name()),
            ])
            ->merge([
                'search' => request()->input("$this->filtersKey.search"),
            ])
            ->filter()
            ->merge([
                'per_page' => $this->getPerPage(),
            ])
            ->toArray();
    }

    public function getPerPage()
    {
        return (int) request()->input("{$this->filtersKey}.per_page", $this->query['per_page']);
    }
}
