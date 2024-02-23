<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Exception\AmountOutOfRangeException;
use PragmaGoTech\Interview\Exception\CannotFindRangeForAmount;
use PragmaGoTech\Interview\Exception\TermValueException;
use PragmaGoTech\Interview\ValueObject\FeeRange;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\FeeRangeRuleset;

readonly class FeeCalculatorByRange implements FeeCalculator
{
    public function __construct(private FeeRangeRuleset $ruleset)
    {
    }

    public function calculate(LoanProposal $application): float
    {
        $amount = $application->amount();
        $term = $application->term();
        if (!$this->ruleset->isValidAmount($amount)) {
            throw AmountOutOfRangeException::create($amount);
        }

        if (!$this->ruleset->isValidTerm($term)) {
            throw TermValueException::create($term);
        }

        $range = $this->ruleset->getRanges()->findByTermAndAmount($term, $amount);
        if ($range === null) {
            throw CannotFindRangeForAmount::create(
                $application->term(),
                $application->amount()
            );
        }

        return $this->calculateFromFeeRange($range, $amount);
    }

    private function calculateFromFeeRange(FeeRange $range, float $amount): float
    {
        $percent = ($range->feeTo - $range->feeFrom) / ($range->amountTo - $range->amountFrom);

        $additionalFee = $percent * ($amount - $range->amountFrom);

        $result = $range->feeFrom + $additionalFee;

        return ceil($result / 5) * 5;
    }
}
