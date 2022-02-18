<?php

namespace Tests\Unit\Repositories;

use App\Models\Loan;
use App\Models\RepaymentSchedule;
use App\Repositories\RepaymentScheduleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RepaymentScheduleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->repaymentScheduleRepository = $this->app->make(RepaymentScheduleRepository::class);
    }

    public function test_insert()
    {
        $loan_id = Loan::factory()->create()->id;
        $data_arr = [[
            'loan_id' => $loan_id,
            'payment_no' => 1,
            'date' => '2021-01-01',
            'payment_amount' => 879.158872,
            'principal' => 795.825538,
            'interest' => 83.333333,
            'balance' => 9204.174461,
        ],[
            'loan_id' => $loan_id,
            'payment_no' => 2,
            'date' => '2021-02-01',
            'payment_amount' => 879.158872,
            'principal' => 802.457418,
            'interest' => 76.701453,
            'balance' => 8401.717042, 
        ]];

        $repayment_schedules = $this->repaymentScheduleRepository->insert($data_arr);

        foreach ($data_arr as &$data) {
            $this->assertDatabaseHas('repayment_schedules', [
                'payment_no' => $data['payment_no'],
                'date' => $data['date'],
                'payment_amount' => $data['payment_amount'],
                'principal' => $data['principal'],
                'interest' => $data['interest'],
                'balance' => $data['balance'],
            ]);
        }
    }

    public function test_delete_by_loan_id()
    {
        $loan_id = Loan::factory()->create()->id;
        $repayment_schedules = RepaymentSchedule::factory(2)->create([
            'loan_id' => $loan_id,
        ]);

        $deleted_repayment_schedules = $this->repaymentScheduleRepository->deleteByLoanId($loan_id);

        foreach ($repayment_schedules as &$repayment_schedule) {
            $this->assertDatabaseMissing('repayment_schedules', [
                'id' => $repayment_schedule->id
            ]);
        }
    }
}