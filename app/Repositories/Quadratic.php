<?php

namespace App\Repositories;

class Quadratic extends Equation
{
    // y=ax^2+bx+c

    public function __construct(float $a, float $b, float $c)
    {
        parent::__construct(EquationValue::QUADRATIC, ['a' => $a, 'b' => $b, 'c' => $c]);
    }

    public function getXInts(): array
    {
        return [
            new EquationValue(($this->getNegativeB() + $this->getDiscriminant()) / $this->getTwoA()),
            new EquationValue(($this->getNegativeB() - $this->getDiscriminant()) / $this->getTwoA())
        ];
    }

    public function getYInts(): array
    {
        return [
            new EquationValue($this->vars['c'])
        ];
    }

    public function getY(float $x): EquationValue
    {
        return new EquationValue($this->vars['a'] * $x ** 2 + $this->vars['b'] * $x + $this->vars['c']);
    }

    public function getNegativeB(): float|int
    {
		return -1 * $this->vars['b'];
	}

    public function getDiscriminant(): float|int
    {
		return sqrt($this->vars['b'] ** 2 - 4 * $this->vars['a'] * $this->vars['c']);
	}

	public function getTwoA(): float|int
    {
		return 2 * $this->vars['a'];
	}
}
