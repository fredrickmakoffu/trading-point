<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Requests\Company\StoreRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(StoreRequest $request) : CompanyResource {
        return new CompanyResource([]);
    }
}
