<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\SearchRequest;
use App\Http\Requests\Loan\StoreRequest;
use App\Http\Requests\Loan\UpdateRequest;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index(SearchRequest $request) {
        $request->validated();

        $data = $request->only([
            'min_loan_amount',
            'max_loan_amount',
            'min_loan_term',
            'max_loan_term',
            'min_interest_rate',
            'max_interest_rate'
        ]);

        return $this->loanService->getByFilter($data);
    }

    public function show($id)
    {
        return $this->loanService->getById($id);
    }

    public function store(StoreRequest $request)
    {
        $request->validated();

        $data = $request->only([
            'loan_amount',
            'loan_term',
            'interest_rate',
            'started_at'
        ]);

        return $this->loanService->saveLoanData($data);
    }

    public function update(UpdateRequest $request, $id)
    {
        $request->validated();

        $data = $request->only([
            'loan_amount',
            'loan_term',
            'interest_rate',
            'started_at'
        ]);

        return $this->loanService->updateLoan($data, $id);
    }

    public function destroy($id)
    {
        return $this->loanService->deleteById($id);
    }
}
