<?php

namespace Tests\Unit\Services;

use App\Models\Loan;
use App\Models\RepaymentSchedule;
use App\Services\LoanService;
use App\Repositories\LoanRepository;
use App\Repositories\RepaymentScheduleRepository;
use Tests\TestCase;
use Mockery;

class LoanServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loanRepository = Mockery::mock(LoanRepository::class);
        $this->repaymentScheduleRepository = Mockery::mock(RepaymentScheduleRepository::class);
        $this->loanService = new LoanService($this->loanRepository, $this->repaymentScheduleRepository);
    }

    public function test_delete_by_id()
    {
        $loan = Loan::factory()->make([
            'id' => 1,
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);

        $this->repaymentScheduleRepository->shouldReceive('deleteByLoanId')->once();
        $this->loanRepository->shouldReceive('delete')->once()->andReturn($loan);

        $deleated_loan = $this->loanService->deleteById($loan->id);

        $this->assertEquals(10000, $deleated_loan->loan_amount);
        $this->assertEquals(1, $deleated_loan->loan_term);
        $this->assertEquals(10, $deleated_loan->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $deleated_loan->started_at);
    }

    public function test_get_by_filter()
    {
        $loan_1 = Loan::factory()->make([
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);
        $loan_2 =  Loan::factory()->make([
            'loan_amount' => 20000,
            'loan_term' => 2,
            'interest_rate' => 20,
            'started_at' => '2021-02-01 00:00:00',
        ]);

        $this->loanRepository->shouldReceive('getByFilter')->once()->andReturn([$loan_1, $loan_2]);

        $loans = $this->loanService->getByFilter([]);

        $this->assertEquals(10000, $loans[0]->loan_amount);
        $this->assertEquals(1, $loans[0]->loan_term);
        $this->assertEquals(10, $loans[0]->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $loans[0]->started_at);
        $this->assertEquals(20000, $loans[1]->loan_amount, 20000);
        $this->assertEquals(2, $loans[1]->loan_term);
        $this->assertEquals(20, $loans[1]->interest_rate);
        $this->assertEquals('2021-02-01 00:00:00', $loans[1]->started_at);
    }

    public function test_get_by_id()
    {
        $loan = Loan::factory()->make([
            'id' => 1,
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);

        $this->loanRepository->shouldReceive('getById')->once()->andReturn($loan);

        $response = $this->loanService->getById($loan->id);

        $this->assertEquals(10000, $response->loan_amount);
        $this->assertEquals(1, $response->loan_term);
        $this->assertEquals(10, $response->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $response->started_at);
    }

    public function test_update_loan()
    {
        $loan = Loan::factory()->make([
            'id' => 1,
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);

        $data = [
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00'
        ];

        $this->loanRepository->shouldReceive('update')->once()->andReturn($loan);
        $this->repaymentScheduleRepository->shouldReceive('deleteByLoanId')->once();
        $this->repaymentScheduleRepository->shouldReceive('insert')->once();

        $updated_loan = $this->loanService->updateLoan($data, $loan->id);
        
        $this->assertEquals(10000, $updated_loan->loan_amount);
        $this->assertEquals(1, $updated_loan->loan_term);
        $this->assertEquals(10, $updated_loan->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $updated_loan->started_at);
    }

    public function test_save_loan_data()
    {
        $data = [
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00'
        ];

        $this->loanRepository->shouldReceive('save')->once()->andReturn(
            Loan::factory()->make([
                'id' => 1,
                'loan_amount' => 10000,
                'loan_term' => 1,
                'interest_rate' => 10,
                'started_at' => '2021-01-01 00:00:00',
            ])
        );
        $this->repaymentScheduleRepository->shouldReceive('insert')->once();

        $loan = $this->loanService->saveLoanData($data);

        $this->assertEquals(10000, $loan->loan_amount);
        $this->assertEquals(1, $loan->loan_term);
        $this->assertEquals(10, $loan->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $loan->started_at);
    }
}