<?php

namespace App\Repositories;

class EquationValue implements \JsonSerializable
{
    private float $number;
    private const ROUND_PRECISION = 5;
    private const NAN_MESSAGE = 'no real solution';
    public const QUADRATIC = 'quadratic';
    public const LINEAR = 'linear';
    public const EXPONENTIAL = 'exponential';
    public const SQUARE_ROOT = 'square-root';
    public const ABSOLUTE_VALUE = 'absolute-value';

    public function __construct(float $number)
    {
        $this->number = $number;
    }

    public function getValue(): float|string
    {
        return is_nan($this->number) ? self::NAN_MESSAGE : round($this->number, self::ROUND_PRECISION);
    }

    public function removeExtraneousSolution(callable $getY, float $expectedValue = 0): void
    {
        if ($getY($this->number) != $expectedValue)
        {
            $this->number = sqrt(-1);
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->getValue()
        ];
    }
}
