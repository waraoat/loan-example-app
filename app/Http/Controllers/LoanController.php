<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loan\StoreRequest;
use App\Http\Requests\Loan\UpdateRequest;
use App\Http\Services\LoanService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use InvalidArgumentException;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index()
    {
        $loans = $this->loanService->getAll();
        return view('loan.index', compact('loans'));
    }

    public function create()
    {
        return view('loan.create');
    }

    public function store(StoreRequest $request)
    {
        $validator = $request->validated();

        $data = $request->only([
            'loan_amount',
            'loan_term',
            'interest_rate',
            'started_at'
        ]);

        try {
            $this->loanService->saveLoanData($data);
            return redirect(route('loans.index'))->with('message', 'Create loan successfully!');
        } catch (Exception $e) {
            return redirect(route('loans.index'))->with('error', $e->getMessage());
        } 
    }

    public function show($id)
    {
        try {
            $loan = $this->loanService->getById($id);
            return view('loan.detail', compact('loan'));
        } catch (Exception $e) {
            return redirect(route('loans.index'))->with('error', $e->getMessage());
        } 
    }

    public function edit($id)
    {
        try {
            $loan = $this->loanService->getById($id);
            return view('loan.edit', compact('loan'));
        } catch (Exception $e) {
            return redirect(route('loans.index'))->with('error', $e->getMessage());
        } 
      }

    public function update(UpdateRequest $request, $id)
    {
        $validator = $request->validated();

        $data = $request->only([
            'loan_amount',
            'loan_term',
            'interest_rate',
            'started_at'
        ]);

        try {
            $this->loanService->updateLoan($data, $id);
            return redirect(route('loans.index'))->with('message', 'Update loan successfully!');
        } catch (Exception $e) {
            return redirect(route('loans.index'))->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->loanService->deleteById($id);
            return redirect(route('loans.index'))->with('message', 'Delete loan successfully!');
        } catch (Exception $e) {
            return redirect(route('loans.index'))->with('error', $e->getMessage());
        }
    }
}
