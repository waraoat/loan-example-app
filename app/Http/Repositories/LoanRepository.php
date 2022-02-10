<?php

namespace App\Http\Repositories;

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

    public function getById($id)
    {
        return $this->loan
            ->find($id);
    }

    public function save($data)
    {
        $loan = new $this->loan;

        $loan->loan_amount = $data['loan_amount'];
        $loan->loan_term = $data['loan_term'];
        $loan->interest_rate = $data['interest_rate'];
        $loan->created_at = $data['created_at'];

        $loan->save();

        return $loan->fresh();
    }

    public function update($data, $id)
    {
        
        $loan = $this->loan->find($id);

        $loan->loan_amount = $data['loan_amount'];
        $loan->loan_term = $data['loan_term'];
        $loan->interest_rate = $data['interest_rate'];
        $loan->created_at = $data['created_at'];

        $loan->update();

        return $loan;
    }

    public function delete($id)
    {
        
        $loan = $this->loan->find($id);
        $loan->delete();

        return $loan;
    }

}