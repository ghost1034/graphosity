<?php

namespace App\Repositories;

class Linear extends Equation
{
    // y=mx+b

    public function __construct(float $m, float $b)
    {
        parent::__construct(EquationValue::LINEAR, ['m' => $m, 'b' => $b]);
    }

    public function getXInts(): array
    {
        return [
            new EquationValue(-1 * $this->vars['b'] / $this->vars['m'])
        ];
    }

    public function getYInts(): array
    {
        return [
            new EquationValue($this->vars['b'])
        ];
    }

    public function getY(float $x): EquationValue
    {
        return new EquationValue($this->vars['m'] * $x + $this->vars['b']);
    }
}
