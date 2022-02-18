<?php

namespace Tests\Unit\Routes;

use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoanControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    
    public function test_loan_index_return_200()
    {
        $response = $this->call('GET', '/loans');

        $response->assertStatus(200);
        $response->assertViewIs('loan.index');
        $response->assertViewHas('loans');
    }

    public function test_loan_create_return_200()
    {
        $response = $this->call('GET', '/loans/create');

        $response->assertStatus(200);
        $response->assertViewIs('loan.create');
    }

    public function test_loan_show_return_200()
    {
        $loan = Loan::factory()->create();
        $response = $this->call('GET', sprintf("/loans/%s", $loan->id));

        $response->assertStatus(200);
        $response->assertViewIs('loan.detail');
        $response->assertViewHas('loan');
    }

    public function test_loan_edit_return_200()
    {
        $loan = Loan::factory()->create();
        $response = $this->call('GET', sprintf("/loans/%s/edit", $loan->id));

        $response->assertStatus(200);
        $response->assertViewIs('loan.edit');
        $response->assertViewHas('loan');
    }

    public function test_loan_edit_return_404()
    {
        $random_id = 9999;
        $response = $this->call('GET', sprintf("/loans/%s/edit", $random_id));

        $response->assertStatus(404);
    }

    public function test_loan_store_return_302()
    {
        $response = $this->call('POST', '/loans', [
            'loan_amount' => 10000,
            'loan_term' => 5,
            'interest_rate' => 10,
            'month' => 1,
            'year' => 2021
        ]);

        $response->assertRedirect('/loans');
        $this->assertDatabaseHas('loans', [
            'loan_amount' => 10000,
            'loan_term' => 5,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);
    }

    public function test_loan_store_when_invalid_param_return_302_with_error_message()
    {
        session()->setPreviousUrl('/loans/create');

        $response = $this->call('POST', '/loans', [
            'loan_amount' => 1,
            'loan_term' => 5,
            'interest_rate' => 10,
            'month' => 1,
            'year' => 2021
        ]);

        $response->assertRedirect('/loans/create');
        $response->assertSessionHasErrors([
            'loan_amount' => 'The loan amount must be at least 1000.'
        ]);
    }
    
    public function test_loan_update_return_302()
    {
        $loan = Loan::factory()->create();
        $response = $this->call('PUT', sprintf("/loans/%s", $loan->id), [
            'id' => $loan->id,
            'loan_amount' => 10000,
            'loan_term' => 6,
            'interest_rate' => 10,
            'month' => 2,
            'year' => 2021
        ]);

        $response->assertRedirect('/loans');
        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'loan_amount' => 10000,
            'loan_term' => 6,
            'interest_rate' => 10,
            'started_at' => '2021-02-01 00:00:00',
        ]);
    }

    public function test_loan_update_when_invalid_param_return_302_with_error_message()
    {
        $loan = Loan::factory()->create();
        session()->setPreviousUrl(sprintf('/loans/%s/edit', $loan->id));

        $response = $this->call('PUT', sprintf('/loans/%s', $loan->id), [
            'id' => $loan->id,
            'loan_amount' => 1,
            'loan_term' => 6,
            'interest_rate' => 10,
            'month' => 2,
            'year' => 2021
        ]);

        $response->assertRedirect(sprintf('/loans/%s/edit', $loan->id));
        $response->assertSessionHasErrors([
            'loan_amount' => 'The loan amount must be at least 1000.'
        ]);
    }

    public function test_loan_destroy_return_200()
    {
        $loan = Loan::factory()->create();
        $response = $this->call('DELETE', sprintf("/loans/%s", $loan->id));

        $response->assertRedirect('/loans');
        $this->assertDatabaseMissing('loans', [
            'id' => $loan->id,
            'loan_amount' => $loan->loan_amount,
            'loan_term' => $loan->loan_term,
            'interest_rate' => $loan->interest_rate,
            'started_at' => $loan->crerated_at,
        ]);
    }

    public function test_loan_destroy_return_404()
    {
        $random_id = 9999;
        $response = $this->call('DELETE', sprintf("/loans/%s", $random_id));

        $response->assertStatus(404);
    }
}
