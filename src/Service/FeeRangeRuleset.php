<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Service;

use PragmaGoTech\Interview\ValueObject\FeeRange;
use PragmaGoTech\Interview\ValueObject\FeeRangeCollection;

class FeeRangeRuleset
{
    private const MIN_AMOUNT = 1000;
    private const MAX_AMOUNT = 20000;

    private array $ruleset = [
        ['term' => 12, 'amountFrom' => 1000, 'amountTo' => 2000, 'feeFrom' => 50, 'feeTo' => 90],
        ['term' => 12, 'amountFrom' => 2000, 'amountTo' => 3000, 'feeFrom' => 90, 'feeTo' => 90],
        ['term' => 12, 'amountFrom' => 3000, 'amountTo' => 4000, 'feeFrom' => 90, 'feeTo' => 115],
        ['term' => 12, 'amountFrom' => 4000, 'amountTo' => 5000, 'feeFrom' => 115, 'feeTo' => 100],
        ['term' => 12, 'amountFrom' => 5000, 'amountTo' => 6000, 'feeFrom' => 100, 'feeTo' => 120],
        ['term' => 12, 'amountFrom' => 6000, 'amountTo' => 7000, 'feeFrom' => 120, 'feeTo' => 140],
        ['term' => 12, 'amountFrom' => 7000, 'amountTo' => 8000, 'feeFrom' => 140, 'feeTo' => 160],
        ['term' => 12, 'amountFrom' => 8000, 'amountTo' => 9000, 'feeFrom' => 160, 'feeTo' => 180],
        ['term' => 12, 'amountFrom' => 9000, 'amountTo' => 10000, 'feeFrom' => 180, 'feeTo' => 200],
        ['term' => 12, 'amountFrom' => 10000, 'amountTo' => 11000, 'feeFrom' => 200, 'feeTo' => 220],
        ['term' => 12, 'amountFrom' => 11000, 'amountTo' => 12000, 'feeFrom' => 220, 'feeTo' => 240],
        ['term' => 12, 'amountFrom' => 12000, 'amountTo' => 13000, 'feeFrom' => 240, 'feeTo' => 260],
        ['term' => 12, 'amountFrom' => 13000, 'amountTo' => 14000, 'feeFrom' => 260, 'feeTo' => 280],
        ['term' => 12, 'amountFrom' => 14000, 'amountTo' => 15000, 'feeFrom' => 280, 'feeTo' => 300],
        ['term' => 12, 'amountFrom' => 15000, 'amountTo' => 16000, 'feeFrom' => 300, 'feeTo' => 320],
        ['term' => 12, 'amountFrom' => 16000, 'amountTo' => 17000, 'feeFrom' => 320, 'feeTo' => 340],
        ['term' => 12, 'amountFrom' => 17000, 'amountTo' => 18000, 'feeFrom' => 340, 'feeTo' => 360],
        ['term' => 12, 'amountFrom' => 18000, 'amountTo' => 19000, 'feeFrom' => 360, 'feeTo' => 380],
        ['term' => 12, 'amountFrom' => 19000, 'amountTo' => 20000, 'feeFrom' => 380, 'feeTo' => 400],
        ['term' => 24, 'amountFrom' => 1000, 'amountTo' => 2000, 'feeFrom' => 70, 'feeTo' => 100],
        ['term' => 24, 'amountFrom' => 2000, 'amountTo' => 3000, 'feeFrom' => 100, 'feeTo' => 120],
        ['term' => 24, 'amountFrom' => 3000, 'amountTo' => 4000, 'feeFrom' => 120, 'feeTo' => 160],
        ['term' => 24, 'amountFrom' => 4000, 'amountTo' => 5000, 'feeFrom' => 160, 'feeTo' => 200],
        ['term' => 24, 'amountFrom' => 5000, 'amountTo' => 6000, 'feeFrom' => 200, 'feeTo' => 240],
        ['term' => 24, 'amountFrom' => 6000, 'amountTo' => 7000, 'feeFrom' => 240, 'feeTo' => 280],
        ['term' => 24, 'amountFrom' => 7000, 'amountTo' => 8000, 'feeFrom' => 280, 'feeTo' => 320],
        ['term' => 24, 'amountFrom' => 8000, 'amountTo' => 9000, 'feeFrom' => 320, 'feeTo' => 360],
        ['term' => 24, 'amountFrom' => 9000, 'amountTo' => 10000, 'feeFrom' => 360, 'feeTo' => 400],
        ['term' => 24, 'amountFrom' => 10000, 'amountTo' => 11000, 'feeFrom' => 400, 'feeTo' => 440],
        ['term' => 24, 'amountFrom' => 11000, 'amountTo' => 12000, 'feeFrom' => 440, 'feeTo' => 480],
        ['term' => 24, 'amountFrom' => 12000, 'amountTo' => 13000, 'feeFrom' => 480, 'feeTo' => 520],
        ['term' => 24, 'amountFrom' => 13000, 'amountTo' => 14000, 'feeFrom' => 520, 'feeTo' => 560],
        ['term' => 24, 'amountFrom' => 14000, 'amountTo' => 15000, 'feeFrom' => 560, 'feeTo' => 600],
        ['term' => 24, 'amountFrom' => 15000, 'amountTo' => 16000, 'feeFrom' => 600, 'feeTo' => 640],
        ['term' => 24, 'amountFrom' => 16000, 'amountTo' => 17000, 'feeFrom' => 640, 'feeTo' => 680],
        ['term' => 24, 'amountFrom' => 17000, 'amountTo' => 18000, 'feeFrom' => 680, 'feeTo' => 720],
        ['term' => 24, 'amountFrom' => 18000, 'amountTo' => 19000, 'feeFrom' => 720, 'feeTo' => 760],
        ['term' => 24, 'amountFrom' => 19000, 'amountTo' => 20000, 'feeFrom' => 760, 'feeTo' => 800],];


    public function getRanges(): FeeRangeCollection
    {
        $collection = new FeeRangeCollection();

        foreach ($this->ruleset as $rule) {
            $collection->addRange(
                new FeeRange(
                    $rule['term'],
                    $rule['amountFrom'],
                    $rule['amountTo'],
                    $rule['feeFrom'],
                    $rule['feeTo'],
                )
            );
        }

        return $collection;
    }


    public function isValidAmount(float $amount): bool
    {
        return $amount >= self::MIN_AMOUNT && $amount <= self::MAX_AMOUNT;
    }

    public function isValidTerm(int $term): bool
    {
        return $term === 12 || $term === 24;
    }
}
