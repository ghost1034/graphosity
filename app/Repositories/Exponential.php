<?php

namespace App\Repositories;

class Exponential extends Equation
{
    // y=ab^x+c

    public function __construct(float $a, float $b, float $c)
    {
        parent::__construct(EquationValue::EXPONENTIAL, ['a' => $a, 'b' => $b, 'c' => $c]);
    }

    public function getXInts(): array
    {
        return [
            new EquationValue(log(-1 * $this->vars['c'] / $this->vars['a']) / log($this->vars['b']))
        ];
    }

    public function getYInts(): array
    {
        return [
            new EquationValue($this->vars['a'] + $this->vars['c'])
        ];
    }

    public function getY(float $x): EquationValue
    {
        return new EquationValue($this->vars['a'] * $this->vars['b'] ** $x + $this->vars['c']);
    }
}
