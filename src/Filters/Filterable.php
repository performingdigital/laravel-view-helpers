<?php

namespace Performing\View\Filters;

use Performing\View\Operators\Operator;
use Illuminate\Database\Eloquent\Builder;

interface Filterable
{
    public function title(): string;

    public function key(): string;

    public function hint(): ?string;

    public function placeholder(): ?string;

    public function type(): string;

    /** @return array<string, string|array> */
    public function props(): array;

    /** @return Operator[] */
    public function operators(): array;

    public function apply(Builder $query, string $operator, string $value): void;
}
