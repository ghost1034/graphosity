<?php

namespace App\Repositories;

use App\Services\CalculatorService;

class Term
{
    private float $number;
    private string $variable;
    private TermCollection $nest;

    public function __construct(string $term)
    {
        $parts = [];
        preg_match('/([+-]|^)(\d*)([^()]*)((?:\(.*\))*)/', $term, $parts);
        $operator = $parts[1] == '' ? '+' : $parts[1];
        $number = $parts[2] == '' ? 1 : $parts[2];
        $this->number = (float) ($operator . $number);
        $this->variable = $parts[3];
        $this->nest = $this->nest($parts[4]);
    }

    public function getNumber(): float
    {
        return $this->number;
    }

    public function getVariable(): string
    {
        return $this->variable;
    }

    public function getNest(): TermCollection
    {
        return $this->nest;
    }

    public function evaluate(): TermCollection
    {
        $originalVars = ['', 'x', 'x^2'];
        $nests = $this->nest;

        foreach ($nests->getTerms() as $term) {
            $term->number *= $this->number;
            $shiftIndex = array_search($term->variable, $originalVars) + array_search($this->variable, $originalVars);
            if (array_key_exists($shiftIndex, $originalVars)) {
                $term->variable = $originalVars[$shiftIndex];
            } else {
                throw new \Exception('Variable out of bounds for equation type');
            }
        }

        return $nests;
    }

    public function flip(): void
    {
        $this->number *= -1;
    }

    private function nest(string $value): TermCollection
    {
        $matches = [];
        preg_match_all('/\(((?:[^()]|(?R))*)\)/', $value, $matches);
        $nests = $matches[1];
        $result = new TermCollection([], []);

        if (count($nests)) {
            for ($j = 0; $j < count($nests); $j++) {
                $result = CalculatorService::splitTerms($nests[$j]);
            }
        }

        return $result;
    }
}
