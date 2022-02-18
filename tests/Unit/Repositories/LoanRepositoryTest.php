<?php

namespace Tests\Unit\Repositories;

use App\Models\Loan;
use App\Repositories\LoanRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoanRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->loanRepository = $this->app->make(LoanRepository::class);
    }

    public function test_get_all()
    {
        $loan_1 = Loan::factory()->create([
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);
        $loan_2 =  Loan::factory()->create([
            'loan_amount' => 20000,
            'loan_term' => 2,
            'interest_rate' => 20,
            'started_at' => '2021-02-01 00:00:00',
        ]);
        
        $loans = $this->loanRepository->getAll();

        $this->assertEquals(10000, $loans[0]->loan_amount);
        $this->assertEquals(1, $loans[0]->loan_term);
        $this->assertEquals(10, $loans[0]->interest_rate);
        $this->assertEquals('2021-01-01 00:00:00', $loans[0]->started_at);
        $this->assertEquals(20000, $loans[1]->loan_amount, 20000);
        $this->assertEquals(2, $loans[1]->loan_term);
        $this->assertEquals(20, $loans[1]->interest_rate);
        $this->assertEquals('2021-02-01 00:00:00', $loans[1]->started_at);
    }

    public function test_get_by_id_when_loan_id_already_exists()
    {
        $loan_id = Loan::factory()->create([
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-02-01 00:00:00',
        ])->id;

        $loan = $this->loanRepository->getById($loan_id);

        $this->assertEquals(10000, $loan->loan_amount);
        $this->assertEquals(1, $loan->loan_term);
        $this->assertEquals(10, $loan->interest_rate);
        $this->assertEquals('2021-02-01 00:00:00', $loan->started_at);
    }

    public function test_save()
    {
        $data = [
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-02-01 00:00:00',
        ];
        $created_loan = $this->loanRepository->save($data);

        $this->assertEquals(10000, $created_loan->loan_amount);
        $this->assertEquals(1, $created_loan->loan_term);
        $this->assertEquals(10, $created_loan->interest_rate);
        $this->assertEquals('2021-02-01 00:00:00', $created_loan->started_at);
        $this->assertDatabaseHas('loans', [
            'id' => $created_loan->id,
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-02-01 00:00:00',
        ]);
    }

    public function test_update_when_loan_id_already_exists()
    {
        $loan_id = Loan::factory()->create()->id;

        $data = [
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-02-01 00:00:00',
        ];
        $updated_loan = $this->loanRepository->update($data, $loan_id);

        $this->assertEquals(10000, $updated_loan->loan_amount);
        $this->assertEquals(1, $updated_loan->loan_term);
        $this->assertEquals(10, $updated_loan->interest_rate);
        $this->assertEquals('2021-02-01 00:00:00', $updated_loan->started_at);
        $this->assertDatabaseHas('loans', [
            'id' => $loan_id,
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-02-01 00:00:00',
        ]);
    }

    public function test_delete_when_loan_id_already_exists()
    {
        $loan_id = Loan::factory()->create()->id;
        $deleted_loan = $this->loanRepository->delete($loan_id);

        $this->assertEquals($loan_id, $deleted_loan->id);
        $this->assertDatabaseMissing('loans', [
            'id' => $loan_id,
            'loan_amount' => $deleted_loan->loan_amount,
            'loan_term' => $deleted_loan->loan_term,
            'interest_rate' => $deleted_loan->interest_rate,
            'started_at' => $deleted_loan->crerated_at,
        ]);
    }
}