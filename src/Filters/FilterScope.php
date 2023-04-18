<?php

namespace Performing\View\Filters;

use Illuminate\Database\Eloquent\Builder;
use Performing\View\Factories\OperatorFactory;
use Performing\View\Operators\IsEqual;

trait FilterScope
{
    private $value = null;

    private $operator = null;

    public function withValue(string $value)
    {
        $this->value = $value;

        return $this;
    }

    public function withOperator(string $operator)
    {
        $this->operator = OperatorFactory::getOperator($operator);

        return $this;
    }

    public function getSqlOperator(): string
    {
        if (! $this->operator) {
            return (new IsEqual)->toSql();
        }

        return $this->operator->toSql();
    }

    public function getSqlValue()
    {
        if ($this->operator) {
            return $this->operator->transform($this->value);
        }

        return $this->value;
    }

    abstract public function apply(Builder $query): void;
}
