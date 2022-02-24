<?php

namespace App\Repositories;

use App\Models\Loan;
use Carbon\Carbon;

class LoanRepository
{
    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function getAll()
    {
        return $this->loan
            ->get();
    }

    public function getByFilter(object $filter)
    {
        $query = $this->loan;

        if (isset($filter->min_loan_amount)) {
            $query = $query->where('loan_amount', '>=', $filter->min_loan_amount);
        }
        if (isset($filter->max_loan_amount)) {
            $query = $query->where('loan_amount', '<=', $filter->max_loan_amount);
        }
        if (isset($filter->min_loan_term)) {
            $query = $query->where('loan_term', '>=', $filter->min_loan_term);
        }
        if (isset($filter->max_loan_term)) {
            $query =  $query->where('loan_term', '<=', $filter->max_loan_term);
        }
        if (isset($filter->min_interest_rate)) {
            $query = $query->where('interest_rate', '>=', $filter->min_interest_rate);
        }
        if (isset($filter->max_interest_rate)) {
            $query = $query->where('interest_rate', '<=', $filter->max_interest_rate);
        }
        
        return $query->get();
    }

    public function getById($id)
    {
        return $this->loan
            ->with('repayment_schedules')
            ->findOrFail($id);
    }

    public function save($data)
    {
        $loan = new $this->loan;

        $loan->loan_amount = $data['loan_amount'];
        $loan->loan_term = $data['loan_term'];
        $loan->interest_rate = $data['interest_rate'];
        $loan->started_at = $data['started_at'];

        $loan->save();

        return $loan->fresh();
    }

    public function update($data, $id)
    {
        $loan = $this->loan->findOrFail($id);

        $loan->loan_amount = $data['loan_amount'];
        $loan->loan_term = $data['loan_term'];
        $loan->interest_rate = $data['interest_rate'];
        $loan->started_at = $data['started_at'];

        $loan->update();

        return $loan;
    }

    public function delete($id)
    {
        $loan = $this->loan->findOrFail($id);
        $loan->delete();

        return $loan;
    }

}