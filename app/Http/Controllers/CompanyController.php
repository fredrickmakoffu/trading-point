<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Requests\Company\StoreRequest;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function index(StoreRequest $request) : CompanyResource {
        $url = 'https://yh-finance-complete.p.rapidapi.com/yhfhistorical';

        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-RapidAPI-Key' => config('rapidapi.key'),
                'X-RapidAPI-Host' => config('rapidapi.host')
            ])
            ->get($url, [
                'ticker' => $request->validated()['company_symbol'],
                'sdate' => $request->validated()['start_date'],
                'edate' => $request->validated()['end_date']
            ]);

        
        $data = $response->successful() 
            ? $response->json()
            : $response->throw();

        // dispatch(new \App\Jobs\EmailUser($data));

        return new CompanyResource($data);
    }
}
