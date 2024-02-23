<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\ValueObject;

readonly class FeeRange
{
    public function __construct(
        public int $term,
        public float $amountFrom,
        public float $amountTo,
        public float $feeFrom,
        public float $feeTo
    ) {
    }
}
