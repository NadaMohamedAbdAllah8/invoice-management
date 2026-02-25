<?php

namespace App\Taxes;

class VatTaxCalculator extends PercentageTaxCalculator implements TaxCalculatorInterface
{
    protected function getRate(): float
    {
        return 0.15;
    }
}
