<?php

namespace App\Services\Auth\Register;

use App\Models\Residen;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Register\RegisterRepository;

class RegisterServiceImplement extends Service implements RegisterService
{

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
    $otp = mt_rand(1000, 9999);

    $inputData = $registerRequest->all();
    $inputData['otp'] = $otp;
    $inputData['waktu'] = now()->addMinutes(1);
    $inputData['addedbyfk'] = '0';
    $inputData['lastuserfk'] = '0';
    $inputData['angkatanfk'] = '0';
    $inputData['kelasfk'] = '0';
    $inputData['nmpasangan'] = $inputData['nmpasangan'] ?? '';
    $inputData['alamatpasangan'] = $inputData['alamatpasangan'] ?? '';
    $inputData['hppasangan'] = $inputData['hppasangan'] ?? '';
    $inputData['anak'] = $inputData['anak'] ?? '0';
    $inputData['password'] = Hash::make($inputData['password']);
    $inputData['is_verified'] = '0';

    $residen = Residen::create($inputData);

    $curl = curl_init();
    curl_setopt(
      $curl,
      CURLOPT_HTTPHEADER,
      array(
        "Authorization: " . env('FONNTE_TOKEN'),
      )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
      'target' => $residen->hp,
      'message' => "Kode OTP Anda adalah = " . $otp,
    ]));
    curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    return $residen;
  }
  public function verifyOTP(VerifyRequest $verifyRequest, $pk)
  {
    $verifyRequest->validate([
      'otp' => 'required|array|size:4',
    ]);

    $residen = Residen::findOrFail($pk);

    $inputOtp = implode('', $verifyRequest->otp);

    if (strtotime($residen->waktu) >= strtotime(now())) {
        return 2;
    }

    if ($residen->otp == $inputOtp) {
      $residen->update([
        'is_verified' => '1',
      ]);

      return true;
    } else {
      return false;
    }
  }
  public function resendOTP($pk)
  {
    $resendOTP = Residen::findOrFail($pk);

    $newOTP = mt_rand(1000, 9999);

    $resendOTP->update([
      'otp' => $newOTP,
      'waktu' => time()
    ]);

    $curl = curl_init();
    curl_setopt(
      $curl,
      CURLOPT_HTTPHEADER,
      array(
        "Authorization: " . env('FONNTE_TOKEN'),
      )
    );
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
      'target' => $resendOTP->hp,
      'message' => "Kode OTP Anda adalah = " . $newOTP,
    ]));
    curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    return $resendOTP;
  }
}
