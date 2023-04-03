<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormSubmissionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSuccessfulSubmission(): void
    {
        $response = $this->post('/api/company', [
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
            'email' => 'test@email.com',
            'company_symbol' => 'AAPL',
            'company_name' => 'Apple Inc.'
        ]);

        $response->assertStatus(200);
    }

    public function testWrongDateDoesNotSubmit(): void
    {
        $response = $this->post('/api/company', [
            'start_date' => 'Not a Date',
            'end_date' => '2022-01-31',
            'email' => 'test@email.com',
            'company_symbol' => 'AAPL',
            'company_name' => 'Apple Inc.'
        ]);

        $response->assertStatus(400);
    }

    public function testBadEmailDoesNotSubmit(): void
    {
        $response = $this->post('/api/company', [
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
            'email' => 'Not an Email - String',
            'company_symbol' => 'AAPL',
            'company_name' => 'Apple Inc.'
        ]);

        $response->assertStatus(400);
    }

    public function testMissingCompanySymbolDoesNotSubmit(): void
    {
        $response = $this->post('/api/company', [
            'start_date' => '2022-01-01',
            'end_date' => '2022-01-31',
            'email' => 'test@example.com'
        ]);

        $response->assertStatus(400);
    }
}
