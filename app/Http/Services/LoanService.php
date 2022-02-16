<?php

namespace App\Http\Services;

use App\Http\Helpers\RepaymentScheduleHelper;
use App\Http\Repositories\LoanRepository;
use App\Http\Repositories\RepaymentScheduleRepository;
use App\Library\RepaymentScheduleGenerator;
use App\Models\Loan;
use App\Models\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class LoanService
{
    protected $loanRepository;

    public function __construct(LoanRepository $loanRepository, RepaymentScheduleRepository $repaymentScheduleRepository)
    {
        $this->loanRepository = $loanRepository;
        $this->repaymentScheduleRepository = $repaymentScheduleRepository;
    }

    public function deleteById($id)
    {
        $loan = DB::transaction(function () use($id) {
            return $this->loanRepository->delete($id);
        });

        return $loan;
    }

    public function getAll()
    {
        return $this->loanRepository->getAll();
    }

    public function getById($id)
    {
        return $this->loanRepository->getById($id);
    }

    public function updateLoan($data, $id)
    {
        $loan = DB::transaction(function () use($data, $id) {
            $loan = $this->loanRepository->update($data, $id);
            $this->repaymentScheduleRepository->deleteByLoanID($loan->id);
            $this->createRepaymentSchedules($loan);
            return $loan;
        });

        return $loan;
    }

    public function saveLoanData($data)
    {
        $loan = DB::transaction(function () use($data) {
            $loan = $this->loanRepository->save($data);
            $this->createRepaymentSchedules($loan);
            return $loan;
        });

        return $loan;
    }

    private function createRepaymentSchedules(Loan $loan)
    {
        $repayment_schedules = [];
        $total_month = $loan->loan_term * 12;
        $outstanding_balance = $loan->loan_amount;
        $pmt = RepaymentScheduleHelper::calculatePMT($loan->loan_amount, $loan->interest_rate, $loan->loan_term);

        for ($index = 1; $index <= $total_month; $index++) {
            $interest = RepaymentScheduleHelper::calculateInterest($loan->interest_rate, $outstanding_balance);
            $principal = RepaymentScheduleHelper::calculatePrincipal($pmt, $interest);
            $outstanding_balance = $outstanding_balance - $principal;

            $repayment_schedule = [
                'loan_id' => $loan->id,
                'payment_no' => $index,
                'date' => $loan->started_at->copy()->addMonthsNoOverflow($index-1),
                'payment_amount' => $pmt,
                'principal' => $principal,
                'interest' => $interest,
                'balance' => $outstanding_balance,
            ];

            array_push($repayment_schedules, $repayment_schedule);
        }

        return $this->repaymentScheduleRepository->insert($repayment_schedules);
    }
}
