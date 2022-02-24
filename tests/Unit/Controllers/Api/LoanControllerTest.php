<?php

namespace Tests\Unit\Controllers\Api;

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

    public function test_loan_store_return_200()
    {
        $response = $this->call('POST', '/api/loans', [
            'loan_amount' => 10000,
            'loan_term' => 5,
            'interest_rate' => 10,
            'month' => 1,
            'year' => 2021
        ]);

        $response->assertStatus(200);
        $this->assertEquals(10000, $response['loan_amount']);
        $this->assertEquals(5, $response['loan_term']);
        $this->assertEquals(10, $response['interest_rate']);
        $this->assertEquals("2021-01-01T00:00:00.000000Z", $response['started_at']);
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

        $response = $this->call('POST', '/api/loans', [
            'loan_amount' => 100000001,
            'loan_term' => 51,
            'interest_rate' => 37,
            'month' => 13,
            'year' => 2051
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/loans/create');
        $response->assertSessionHasErrors([
            'loan_amount' => 'The loan amount must not be greater than 100000000.',
            'loan_term' => 'The loan term must not be greater than 50.',
            'interest_rate' => 'The interest rate must not be greater than 36.',
            'month' => 'The month must not be greater than 12.',
            'year' => 'The year must not be greater than 2050.'
        ]);

        $response = $this->call('POST', '/api/loans', [
            'loan_amount' => 0,
            'loan_term' => 0,
            'interest_rate' => 0,
            'month' => 0,
            'year' => 2016
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/loans/create');
        $response->assertSessionHasErrors([
            'loan_amount' => 'The loan amount must be at least 1000.',
            'loan_term' => 'The loan term must be at least 1.',
            'interest_rate' => 'The interest rate must be at least 1.',
            'month' => 'The month must be at least 1.',
            'year' => 'The year must be at least 2017.'
        ]);
    }
    
    public function test_loan_update_return_200()
    {
        $loan = Loan::factory()->create();
        $response = $this->call('PUT', sprintf("/api/loans/%s", $loan->id), [
            'id' => $loan->id,
            'loan_amount' => 10000,
            'loan_term' => 6,
            'interest_rate' => 10,
            'month' => 2,
            'year' => 2021
        ]);

        $response->assertStatus(200);
        $this->assertEquals(10000, $response['loan_amount']);
        $this->assertEquals(6, $response['loan_term']);
        $this->assertEquals(10, $response['interest_rate']);
        $this->assertEquals("2021-02-01T00:00:00.000000Z", $response['started_at']);
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

        $response = $this->call('PUT', sprintf('/api/loans/%s', $loan->id), [
            'id' => $loan->id,
            'loan_amount' => 100000001,
            'loan_term' => 51,
            'interest_rate' => 37,
            'month' => 13,
            'year' => 2051
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(sprintf('/loans/%s/edit', $loan->id));
        $response->assertSessionHasErrors([
            'loan_amount' => 'The loan amount must not be greater than 100000000.',
            'loan_term' => 'The loan term must not be greater than 50.',
            'interest_rate' => 'The interest rate must not be greater than 36.',
            'month' => 'The month must not be greater than 12.',
            'year' => 'The year must not be greater than 2050.'
        ]);

        $response = $this->call('PUT', sprintf('/api/loans/%s', $loan->id), [
            'loan_amount' => 0,
            'loan_term' => 0,
            'interest_rate' => 0,
            'month' => 0,
            'year' => 2016
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(sprintf('/loans/%s/edit', $loan->id));
        $response->assertSessionHasErrors([
            'loan_amount' => 'The loan amount must be at least 1000.',
            'loan_term' => 'The loan term must be at least 1.',
            'interest_rate' => 'The interest rate must be at least 1.',
            'month' => 'The month must be at least 1.',
            'year' => 'The year must be at least 2017.'
        ]);
    }

    public function test_loan_destroy_return_200()
    {
        $loan = Loan::factory()->create([
            'loan_amount' => 10000,
            'loan_term' => 5,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00'
        ]);
        
        $response = $this->call('DELETE', sprintf("/api/loans/%s", $loan->id));

        $response->assertStatus(200);
        $this->assertEquals(10000, $response['loan_amount']);
        $this->assertEquals(5, $response['loan_term']);
        $this->assertEquals(10, $response['interest_rate']);
        $this->assertEquals("2021-01-01T00:00:00.000000Z", $response['started_at']);
        $this->assertDatabaseMissing('loans', [
            'id' => $loan->id,
            'loan_amount' => 10000,
            'loan_term' => 5,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);
    }

    public function test_loan_destroy_return_404()
    {
        $random_id = 9999;
        $response = $this->call('DELETE', sprintf("/api/loans/%s", $random_id));

        $response->assertStatus(404);
    }
}
