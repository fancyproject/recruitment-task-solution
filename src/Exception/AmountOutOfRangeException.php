<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

class AmountOutOfRangeException extends \DomainException
{
    public static function create(float $amount): self
    {
        return new self("Given amount is out of range: " . $amount);
    }
}
