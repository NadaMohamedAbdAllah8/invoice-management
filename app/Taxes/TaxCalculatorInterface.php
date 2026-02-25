<?php

namespace App\Taxes;

interface TaxCalculatorInterface
{
    public function calculate(float $amount): float;
}
