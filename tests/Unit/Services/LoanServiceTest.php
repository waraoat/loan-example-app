<?php

namespace Tests\Unit\Services;

use App\Models\Loan;
use App\Models\RepaymentSchedule;
use App\Http\Services\LoanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoanServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->loanService = $this->app->make(LoanService::class);
    }

    public function testDeleteById()
    {
        $loan = Loan::factory()->create();
        $repayment_schedules = RepaymentSchedule::factory(5)->create([
            'loan_id' => $loan->id,
        ]);

        $this->loanService->deleteById($loan->id);
        $this->assertEquals(count($loan->repayment_schedules), 0);
    }

    public function testUpdateLoan()
    {
        $loan = Loan::factory()->create();
        $repayment_schedules = RepaymentSchedule::factory(5)->create([
            'loan_id' => $loan->id,
        ]);

        $data = [
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'month' => 1,
            'year' => 2021
        ];

        $updated_loan = $this->loanService->updateLoan($data, $loan->id);
        
        $this->assertEquals($data['loan_amount'], $updated_loan->loan_amount);
        $this->assertEquals($data['loan_term'], $updated_loan->loan_term);
        $this->assertEquals($data['interest_rate'], $updated_loan->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $updated_loan->created_at);
        $this->assertEquals(12, count($updated_loan->repayment_schedules));
    }

    public function testSaveLoanData()
    {
        $data = [
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'month' => 1,
            'year' => 2021
        ];

        $loan = $this->loanService->saveLoanData($data);

        $this->assertEquals($data['loan_amount'], $loan->loan_amount);
        $this->assertEquals($data['loan_term'], $loan->loan_term);
        $this->assertEquals($data['interest_rate'], $loan->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $loan->created_at);
    }
}