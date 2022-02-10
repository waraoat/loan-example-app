<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $data = $request->only([
            'loan_amount',
            'loan_term',
            'interest_rate',
            'month',
            'year'
        ]);

        try {
            $this->loanService->saveLoanData($data);
            return redirect(route('loan.index'))->with('message', 'Create loan successfully!');
        } catch (InvalidArgumentException $e) {
            return redirect(route('loan.create'))->with('error', $e->getMessage());
        } catch (Exception $e) {
            return redirect(route('loan.index'))->with('error', $e->getMessage());
        } 
    }

    public function show($id)
    {
        try {
            $loan = $this->loanService->getById($id);
            return view('loan.detail', compact('loan'));
        } catch (Exception $e) {
            return redirect(route('loan.index'))->with('error', $e->getMessage());
        } 
    }

    public function edit($id)
    {
        try {
            $loan = $this->loanService->getById($id);
            return view('loan.edit', compact('loan'));
        } catch (Exception $e) {
            return redirect(route('loan.index'))->with('error', $e->getMessage());
        } 
      }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'loan_amount',
            'loan_term',
            'interest_rate',
            'month',
            'year'
        ]);

        try {
            $this->loanService->updateLoan($data, $id);
            return redirect(route('loan.index'))->with('message', 'Update loan successfully!');
        } catch (InvalidArgumentException $e) {
            return redirect(route('loan.edit', $id))->with('error', $e->getMessage());
        } catch (Exception $e) {
            return redirect(route('loan.index'))->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->loanService->deleteById($id);
            return redirect(route('loan.index'))->with('message', 'Delete loan successfully!');
        } catch (Exception $e) {
            return redirect(route('loan.index'))->with('error', $e->getMessage());
        }
    }
}
