<?php

namespace App\Http\Controllers;

use App\Models\RepaymentSchedule;
use App\Models\Loan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::all();

        return view('loan.index', compact('loans'));
    }

    public function create()
    {
        return view('loan.create');
    }

    public function store(Request $request)
    {
        Loan::create(
            [
              'loan_amount' => $request->loan_amount,
              'loan_term' => $request->loan_term,
              'interest_rate' => $request->interest_rate,
              'created_at' => Carbon::create($request->year, $request->month, 1, 00, 00, 00, 'UTC'),
            ]
          );

        return redirect(route('get.loan.index'))->with('message', 'Create loan successfully!');
    }

    public function show(Request $request)
    {
        $loan = Loan::find($request->id);

        return view('loan.detail', compact('loan'));
    }

    public function edit(Request $request)
    {
        $loan = Loan::find($request->id);

        return view('loan.edit', compact('loan'));
      }

    public function update(Request $request)
    {
        $loan = Loan::find($request->id);
        $loan->loan_amount = $request->loan_amount;
        $loan->loan_term = $request->loan_term;
        $loan->interest_rate = $request->interest_rate;
        $loan->created_at = Carbon::create($request->year, $request->month, 1, 00, 00, 00, 'UTC');
        $loan->save();

        return redirect(route('get.loan.index'))->with('message', 'Update loan successfully!');
    }

    public function destroy(Request $request)
    {
        $loan = Loan::find($request->id);
        $loan->delete();

        return redirect(route('get.loan.index'))->with('message', 'Delete loan successfully!');
    }
}
