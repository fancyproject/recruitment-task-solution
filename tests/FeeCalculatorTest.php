<?php

declare(strict_types=1);

namespace PragmaGoTech\tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Exception\AmountOutOfRangeException;
use PragmaGoTech\Interview\Exception\CannotFindRangeForAmount;
use PragmaGoTech\Interview\Exception\TermValueException;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\FeeRangeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Service\FeeRangeRuleset;
use PragmaGoTech\Interview\ValueObject\FeeRangeCollection;

class FeeCalculatorTest extends TestCase
{
    public function test_throw_term_value_exception(): void
    {
        $term = 13;
        $amount = 15000;
        $application = new LoanProposal($term, $amount);
        $calculator = $this->getCalculatorWithRanges();

        $this->expectExceptionObject(TermValueException::create($term));

        $calculator->calculate($application);
    }

    #[DataProvider('outOfRangeDataProvider')]
    public function test_throw_out_of_range_exception(int $term, float $amount): void
    {
        $application = new LoanProposal($term, $amount);
        $calculator = $this->getCalculatorWithRanges();

        $this->expectExceptionObject(AmountOutOfRangeException::create($amount));

        $calculator->calculate($application);
    }

    public function test_amount_out_of_ranges(): void
    {
        $term = 24;
        $amount = 1000;

        $application = new LoanProposal($term, $amount);
        $calculator = $this->getCalculatorWithoutRanges();

        $this->expectExceptionObject(CannotFindRangeForAmount::create($term, $amount));

        $calculator->calculate($application);
    }

    #[DataProvider('feeDataProvider')]
    public function test_calculation(int $term, float $amount, $expectedFee): void
    {
        $application = new  LoanProposal($term, $amount);
        $calculator = $this->getCalculatorWithRanges();
        $fee = $calculator->calculate($application);

        $this->assertEquals($expectedFee, $fee);
    }

    public static function outOfRangeDataProvider(): array
    {
        return [
            [12, 20100],
            [12, 20000.01],
            [24, 999.9999],
            [24, -10000]
        ];
    }


    public static function feeDataProvider(): array
    {
        return [
            [12, 19250, 385],
            [24, 2750, 115],
            [24, 2800, 120],
            [12, 2500, 90], // special range
            [24, 4025.12, 165],
        ];
    }

    private function getCalculatorWithRanges(): FeeCalculator
    {
        return new FeeRangeCalculator(new FeeRangeRuleset());
    }

    private function getCalculatorWithoutRanges(): FeeCalculator
    {
        $mock = $this->createPartialMock(FeeRangeRuleset::class, [
            'getRanges'
        ]);
        $mock->method('getRanges')->willReturn(new FeeRangeCollection());

        return new FeeRangeCalculator($mock);
    }
}
