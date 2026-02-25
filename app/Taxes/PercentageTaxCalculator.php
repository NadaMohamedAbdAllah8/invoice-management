<?php

namespace App\Taxes;

abstract class PercentageTaxCalculator implements TaxCalculatorInterface
{
    abstract protected function getRate(): float;

    public function calculate(float $amount): float
    {
        return $amount * $this->getRate();
    }
}
