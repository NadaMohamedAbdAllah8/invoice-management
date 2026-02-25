<?php

namespace App\Taxes;

class TourismTaxCalculator extends PercentageTaxCalculator implements TaxCalculatorInterface
{
    protected function getRate(): float
    {
        return 0.05;
    }
}
