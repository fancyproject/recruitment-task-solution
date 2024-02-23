<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class TermValueException extends \DomainException
{
    public static function create(float $term): self
    {
        return new self("Given term is out of range: " . $term);
    }
}
