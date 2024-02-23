<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\ValueObject;

use PragmaGoTech\Interview\Model\LoanProposal;
use Traversable;
use IteratorAggregate;
use ArrayIterator;

class FeeRangeCollection implements IteratorAggregate
{

    /**
     * @var array|FeeRange[]
     */
    private array $items = [];

    public function addRange(FeeRange $feeRange): void
    {
        $this->items[] = $feeRange;
    }

    public function findByTermAndAmount(int $term, float $amount): ?FeeRange
    {
        foreach ($this->items as $item) {
            if ($item->term !== $term) {
                continue;
            }

            if ($item->amountFrom <= $amount && $item->amountTo > $amount) {
                return $item;
            }
        }
        return null;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
