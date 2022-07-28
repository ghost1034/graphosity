<?php

namespace App\Repositories;

abstract class Equation implements \JsonSerializable
{
    protected string $type;
    protected array $vars;

    public function __construct(string $type, array $vars)
    {
        $this->type = $type;
        $this->vars = $vars;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'vars' => $this->vars,
            'xInts' => $this->getXInts(),
            'yInts' => $this->getYInts()
        ];
    }

    public abstract function getXInts(): array;
    public abstract function getYInts(): array;
    public abstract function getY(float $x): EquationValue;
}
