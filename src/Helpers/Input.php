<?php

namespace Performing\View\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class Input implements Arrayable
{
    protected string $label;

    protected string $name;

    protected string $type = 'text';

    protected string $help = '';

    protected string $validation = '';

    protected array $options = [];

    public function __construct(string $label, ?string $name = null)
    {
        $this->label = $label;
        $this->name = $name ?? Str::slug($this->label);
    }

    public static function make($label, $name = null): self
    {
        return new static($label, $name);
    }

    public function help(string $help)
    {
        $this->help = $help;

        return $this;
    }

    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function validation(string $validation)
    {
        $this->validation = $validation;

        return $this;
    }

    public function toData(): array
    {
        return [$this->name => ''];
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'label' => $this->label,
            'help' => $this->help,
            'validation' => $this->validation,
            'options' => $this->options,
        ];
    }
}
