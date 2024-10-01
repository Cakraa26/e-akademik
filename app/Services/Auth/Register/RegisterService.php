<?php

namespace App\Services\Auth\Register;

use App\Http\Requests\Auth\RegisterRequest;
use LaravelEasyRepository\BaseService;

interface RegisterService extends BaseService{

    public function register(RegisterRequest $request);
    // public function otp(RegisterRequest $request);
    
}
