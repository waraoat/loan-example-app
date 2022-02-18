<?php

namespace App\Helpers;

class RepaymentScheduleHelper

{
    public static function generateRepaymentSchedules($data)
    {
        $repayment_schedules = [];
        $total_month = $data->loan_term * 12;
        $outstanding_balance = $data->loan_amount;
        $pmt = self::calculatePMT($data->loan_amount, $data->interest_rate, $data->loan_term);

        for ($index = 1; $index <= $total_month; $index++) {
            $interest = self::calculateInterest($data->interest_rate, $outstanding_balance);
            $principal = self::calculatePrincipal($pmt, $interest);
            $outstanding_balance = $outstanding_balance - $principal;

            $repayment_schedule = [
                'payment_no' => $index,
                'date' => $data->started_at->copy()->addMonthsNoOverflow($index-1),
                'payment_amount' => $pmt,
                'principal' => $principal,
                'interest' => $interest,
                'balance' => $outstanding_balance,
            ];

            array_push($repayment_schedules, $repayment_schedule);
        }

        return $repayment_schedules;
    }

    public static function calculatePMT(float $amount, float $interest_rate, int $term_years) {
        return ($amount * (($interest_rate / 100) / 12)) / ((1 - (1 + (($interest_rate / 100) / 12)) ** (-12 * $term_years)));
    }

    public static function calculateInterest(float $interest_rate, float $outstanding_balance) {
        return (($interest_rate / 100) / 12) * $outstanding_balance;
    }

    public static function calculatePrincipal(float $pmt, float $interest)
    {
        return $pmt - $interest;
    }
}