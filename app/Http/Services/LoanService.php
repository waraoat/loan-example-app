<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Http\Repositories\LoanRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class LoanService
{
    protected $loanRepository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $loan = $this->loanRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete loan');
        }
        DB::commit();

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
        $validator = Validator::make($data, [
            'loan_amount' => ['required', 'numeric', 'min:1000', 'max:100000000'],
            'loan_term' => ['required', 'numeric', 'min:1', 'max:50'],
            'interest_rate' => ['required', 'numeric', 'min:1', 'max:36'],
            'month' => ['required', 'numeric', 'min:1', 'max:12'],
            'year' => ['required', 'numeric', 'min:2017', 'max:2050']
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $data['created_at'] = Carbon::create($data['year'], $data['month'], 1, 00, 00, 00, 'UTC');
            $loan = $this->loanRepository->update($data, $id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to update loan data');
        }
        DB::commit();

        return $loan;

    }

    public function saveLoanData($data)
    {
        $validator = Validator::make($data, [
            'loan_amount' => ['required', 'numeric', 'min:1000', 'max:100000000'],
            'loan_term' => ['required', 'numeric', 'min:1', 'max:50'],
            'interest_rate' => ['required', 'numeric', 'min:1', 'max:36'],
            'month' => ['required', 'numeric', 'min:1', 'max:12'],
            'year' => ['required', 'numeric', 'min:2017', 'max:2050']
        ]);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['created_at'] = Carbon::create($data['year'], $data['month'], 1, 00, 00, 00, 'UTC');
        $result = $this->loanRepository->save($data);

        return $result;
    }

}
