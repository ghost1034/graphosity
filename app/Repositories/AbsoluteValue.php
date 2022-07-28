<?php

namespace App\Repositories;

class AbsoluteValue extends Equation
{
    // y=a|x-h|+k

    public function __construct($a, $h, $k)
    {
        parent::__construct(EquationValue::ABSOLUTE_VALUE, ['a' => $a, 'h' => $h, 'k' => $k]);
    }

    public function getXInts(): array
    {
        // May produce extraneous solutions, checks if y is 0
        $x1 = new EquationValue((-1 * $this->vars['k'] / $this->vars['a']) + $this->vars['h']);
        $x2 = new EquationValue(($this->vars['k'] / $this->vars['a']) + $this->vars['h']);

        $function = function(float $number)
        {
            return $this->getY($number)->getValue();
        };

        $x1->removeExtraneousSolution($function);
        $x2->removeExtraneousSolution($function);
        return [$x1, $x2];
    }

    public function getYInts(): array
    {
        return [
            new EquationValue($this->vars['a'] * abs(-1 * $this->vars['h']) + $this->vars['k'])
        ];
    }

    public function getY(float $x): EquationValue
    {
        return new EquationValue($this->vars['a'] * abs($x - $this->vars['h']) + $this->vars['k']);
    }
}
