<?php

namespace App\Repositories;

class TermCollection
{
    private array $terms;

    public function __construct(array $leftTerms, array $rightTerms)
    {
        foreach ($rightTerms as $term) {
            $term->flip();
        }

        $this->terms = array_merge($leftTerms, $rightTerms);
    }

    public function getTerms(): array
    {
        return $this->terms;
    }
}
