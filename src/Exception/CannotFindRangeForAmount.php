<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class CannotFindRangeForAmount extends \DomainException
{
    public static function create(int $term, float $amount): self
    {
        return new self(sprintf("Cannot find range for amount: %f and term %d", $amount, $term));
    }
}
