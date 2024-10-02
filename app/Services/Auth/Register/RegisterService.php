<?php

namespace App\Services\Auth\Register;

use LaravelEasyRepository\BaseService;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Requests\Auth\RegisterRequest;

interface RegisterService extends BaseService{

    public function register(RegisterRequest $request);
    public function verifyOTP(VerifyRequest $verifyRequest, $pk);
    public function resendOTP($pk);
}
