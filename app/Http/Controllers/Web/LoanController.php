<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loan\StoreRequest;
use App\Http\Requests\Loan\UpdateRequest;
use App\Services\LoanService;
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
        return view('loan.index');
    }

    public function create()
    {
        return view('loan.create');
    }

    public function show($id)
    {
        return view('loan.show', compact('id'));
    }

    public function edit($id)
    {
        return view('loan.edit', compact('id'));
      }
}
