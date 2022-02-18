<?php

namespace App\Services;

use App\Helpers\RepaymentScheduleHelper;
use App\Repositories\LoanRepository;
use App\Repositories\RepaymentScheduleRepository;
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
            $this->repaymentScheduleRepository->deleteByLoanId($id);
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
        return DB::transaction(function () use($data, $id) {
            $loan = $this->loanRepository->update($data, $id);
            $this->repaymentScheduleRepository->deleteByLoanId($loan->id);
            $repaymentSchedules = RepaymentScheduleHelper::generateRepaymentSchedules($loan->loan_amount, $loan->loan_term, $loan->interest_rate, $loan->started_at);
            foreach ($repaymentSchedules as $key => $value) { $repaymentSchedules[$key]['loan_id'] = $loan->id; }
            $this->repaymentScheduleRepository->insert($repaymentSchedules);

            return $loan;
        });
    }

    public function saveLoanData($data)
    {
        return DB::transaction(function () use($data) {
            $loan = $this->loanRepository->save($data);
            $repaymentSchedules = RepaymentScheduleHelper::generateRepaymentSchedules($loan->loan_amount, $loan->loan_term, $loan->interest_rate, $loan->started_at);
            foreach ($repaymentSchedules as $key => $value) { $repaymentSchedules[$key]['loan_id'] = $loan->id; }
            $this->repaymentScheduleRepository->insert($repaymentSchedules);

            return $loan;
        });
    }
}
