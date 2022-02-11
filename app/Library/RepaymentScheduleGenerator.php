<?php

namespace App\Library;

use Carbon\Carbon;

class RepaymentScheduleGenerator

{
    public $loan_id;
    public $loan_amount;
    public $loan_term;
    public $interest_rate;
    public $start_date;

    private $pmt;

    public function __construct($input)
    {
        $this->loan_id = $input['loan_id'];
        $this->loan_amount = $input['loan_amount'];
        $this->loan_term = $input['loan_term'];
        $this->interest_rate = $input['interest_rate'] / 100;
        $this->start_date = $input['created_at'];
    }

    public function getRepaymentScheduleData()
    {
        $this->setPMT();

        $repayment_schedules = [];
        $total_month = $this->loan_term * 12;
        $outstanding_balance = $this->loan_amount;

        for ($index = 1; $index <= $total_month; $index++) {

            $interest = $this->getInterest($this->interest_rate, $outstanding_balance);
            $principal = $this->getPrincipal($interest);
            $outstanding_balance = $this->getBalance($outstanding_balance, $principal);

            $repayment_schedule = [
                'loan_id' => $this->loan_id,
                'payment_no' => $index,
                'date' => $this->start_date->copy()->addMonthsNoOverflow($index-1),
                'payment_amount' => $this->pmt,
                'principal' => $principal,
                'interest' => $interest,
                'balance' => $outstanding_balance,
            ];

            array_push($repayment_schedules, $repayment_schedule);

            $outstanding_balance = $repayment_schedule['balance'];
        }
        return $repayment_schedules;
    }

    private function setPMT()
    {
        $this->pmt = ($this->loan_amount * ($this->interest_rate / 12)) / ((1 - (1 + ($this->interest_rate / 12)) ** (-12 * $this->loan_term)));
    }

    private function getInterest($rate, $outstanding_balance)
    {
        return ($rate / 12) * $outstanding_balance;
    }

    private function getPrincipal($interest)
    {
        return $this->pmt - $interest;
    }

    private function getBalance($outstanding_balance, $principal)
    {
        return $outstanding_balance - $principal;
    }
}