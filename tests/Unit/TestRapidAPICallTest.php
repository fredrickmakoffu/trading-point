<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class TestRapidAPICallTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_if_rapid_api_call_works(): void
    {
        $url = 'https://yh-finance-complete.p.rapidapi.com/yhfhistorical';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-RapidAPI-Key' => '2e2580a993msh47b9484ca939a87p10a254jsnd9ed1720d9df',
            'X-RapidAPI-Host' => 'yh-finance-complete.p.rapidapi.com'
        ])
        ->get($url, [
            'ticker' => 'AAPL',
            'sdate' => '2022-01-01',
            'edate' => '2022-01-31'
        ]);

        $this->assertTrue($response->successful());
        $this->assertNotEmpty($response->json());
    }
}
