<?php

namespace App\Services;

use App\Repositories\AbsoluteValue;
use App\Repositories\Equation;
use App\Repositories\EquationValue;
use App\Repositories\Exponential;
use App\Repositories\Linear;
use App\Repositories\Quadratic;
use App\Repositories\SquareRoot;
use App\Repositories\Term;
use App\Repositories\TermCollection;

class CalculatorService
{
    public static function calculate(string $equation, string $type): Equation
    {
        $vars = self::addTerms(self::splitTerms($equation));
        return match ($type) {
            EquationValue::QUADRATIC => new Quadratic(@$vars['x^2'] ?: 0, @$vars['x'] ?: 0, @$vars[''] ?: 0),
            EquationValue::LINEAR => new Linear(3, 5),
            EquationValue::EXPONENTIAL => new Exponential(1, -0.1, 2),
            EquationValue::SQUARE_ROOT => new SquareRoot(-4, 2, 0),
            EquationValue::ABSOLUTE_VALUE => new AbsoluteValue(9, 2, -1),
            default => throw new \Exception('The equation type does not exist')
        };
    }

    public static function splitTerms(string $equation): TermCollection
    {
        $leftMatches = [];
        $rightMatches = [];
        $leftTerms = [];
        $rightTerms = [];
        $pattern = "/(?:[+-]|^)+[^()+-]*(?'nest'\((?:[^()]|(?&nest))*\))*/";
        $parts = explode('=', $equation);

        if (array_key_exists(0, $parts)) {
            preg_match_all($pattern, $parts[0], $leftMatches);
            $leftTerms = self::toTermArray($leftMatches[0]);
        }

        if (array_key_exists(1, $parts)) {
            preg_match_all($pattern, $parts[1], $rightMatches);
            $rightTerms = self::toTermArray($rightMatches[0]);
        }

        return new TermCollection($leftTerms, $rightTerms);
    }

    public static function addTerms(TermCollection $terms): array
    {
        $vars = [];
        foreach ($terms->getTerms() as $term) {
            if (count($term->getNest()->getTerms())) {
                $newVars = self::addTerms($term->evaluate());
                $vars = self::combine($vars, $newVars);
            } else {
                if (array_key_exists($term->getVariable(), $vars)) {
                    $vars[$term->getVariable()] += $term->getNumber();
                } else {
                    $vars[$term->getVariable()] = $term->getNumber();
                }
            }
        }
        return $vars;
    }

    private static function toTermArray(array $terms): array
    {
        $result = [];
        if (count($terms)) {
            for ($i = 0; $i < count($terms); $i++) {
                $result[$i] = new Term($terms[$i]);
            }
        }
        return $result;
    }

    private static function combine(array $vars, array $nests): array
    {
        $arrays = func_get_args();
        $keys = array_keys(array_reduce($arrays, function ($prev, $curr) {
            return $prev + $curr;
        }, array()));

        $sums = array();
        foreach ($keys as $key) {
            $sums[$key] = array_reduce($arrays, function ($sum, $arr) use ($key) {
                return $sum + @$arr[$key];
            });
        }
        return $sums;
    }
}
