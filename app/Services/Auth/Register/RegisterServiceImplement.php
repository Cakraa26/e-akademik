<?php

namespace App\Services\Auth\Register;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Residen;
use LaravelEasyRepository\Service;
use App\Repositories\Register\RegisterRepository;
use Illuminate\Support\Facades\Hash;

class RegisterServiceImplement extends Service implements RegisterService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(Residen $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function register(RegisterRequest $registerRequest)
    {
             $inputData = $registerRequest->all();
            $inputData['addedbyfk'] = '0';
            $inputData['lastuserfk'] = '0';
            $inputData['angkatanfk'] = '0';
            $inputData['kelasfk'] = '0';
            $inputData['password'] = Hash::make($inputData['password']);

            $residen = Residen::create($inputData);

            return $residen;
    }
}
