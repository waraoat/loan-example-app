<?php

namespace App\Http\Helpers;

class RepaymentScheduleHelper

{
    public static function calculatePMT($amount, $interest_rate, $term_years) {
        return ($amount * (($interest_rate / 100) / 12)) / ((1 - (1 + (($interest_rate / 100) / 12)) ** (-12 * $term_years)));
    }

    public static function calculateInterest($interest_rate, $outstanding_balance) {
        return (($interest_rate / 100) / 12) * $outstanding_balance;
    }

    public static function calculatePrincipal($pmt, $interest)
    {
        return $pmt - $interest;
    }
}