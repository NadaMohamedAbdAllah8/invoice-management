<?php

namespace App\Taxes;

class MunicipalFeeCalculator extends PercentageTaxCalculator implements TaxCalculatorInterface
{
    protected function getRate(): float
    {
        return 0.025;
    }
}
