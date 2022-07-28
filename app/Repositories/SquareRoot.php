<?php

namespace App\Repositories;

class SquareRoot extends Equation
{
    // y=a√(x-h)+k

    public function __construct(float $a, float $h, float $k)
    {
        parent::__construct(EquationValue::SQUARE_ROOT, ['a' => $a, 'h' => $h, 'k' => $k]);
    }

    public function getXInts(): array
    {
        // May produce extraneous solutions, checks if y is 0
        $x = new EquationValue((-1 * $this->vars['k'] / $this->vars['a']) ** 2 + $this->vars['h']);

        $function = function(float $number)
        {
            return $this->getY($number)->getValue();
        };

        $x->removeExtraneousSolution($function);
        return [$x];
    }

    public function getYInts(): array
    {
        return [
            new EquationValue($this->vars['a'] * sqrt(-1 * $this->vars['h']) + $this->vars['k'])
        ];
    }

    public function getY(float $x): EquationValue
    {
        return new EquationValue($this->vars['a'] * sqrt($x - $this->vars['h']) + $this->vars['k']);
    }
}
