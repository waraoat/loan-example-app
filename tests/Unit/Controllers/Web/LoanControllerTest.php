<?php

namespace Tests\Unit\Controllers\Web;

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
        $response->assertViewIs('loan.show');
    }

    public function test_loan_edit_return_200()
    {
        $loan = Loan::factory()->create();
        $response = $this->call('GET', sprintf("/loans/%s/edit", $loan->id));

        $response->assertStatus(200);
        $response->assertViewIs('loan.edit');
    }
}
