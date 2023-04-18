<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Performing\View\Filters\FilterableType;
use Performing\View\Filters\FilterType;
use Performing\View\Filters\FilterTypeProp;

class TableFilter extends FilterType
{
    public function __construct(
        protected string $label,
        protected string $type = 'text',
        protected array $operators = [],
        protected array $options = [],
        protected $callback = null,
    ) {}

    public static function make(string $label)
    {
        return new static($label);
    }

    public function label(): string
    {
        return $this->label;
    }

    public function type(): string
    {
        return $this->type;
    }

    #[FilterTypeProp]
    public function options(): array
    {
        return $this->options;
    }

    public function operators(): array
    {
        return $this->operators;
    }

    public function withType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function withOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function withOperators(array $operators): self
    {
        $this->operators = $operators;

        return $this;
    }

    public function withCallback($callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function apply(Builder $query): void
    {
        if ($this->callback) {
            call_user_func(\Closure::bind($this->callback, $this), $query);
        } else {
            $query->where($this->name(), $this->getSqlOperator(), $this->getSqlValue());
        }
    }
}
