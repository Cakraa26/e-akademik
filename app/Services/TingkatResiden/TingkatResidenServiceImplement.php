<?php

namespace App\Services\TingkatResiden;

use App\Http\Requests\TingkatResiden\CreateTingkatResidenRequest;
use App\Http\Requests\TingkatResiden\UpdateTingkatResidenRequest;
use App\Models\TingkatResiden;
use LaravelEasyRepository\Service;

class TingkatResidenServiceImplement extends Service implements TingkatResidenService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(TingkatResiden $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAll()
  {
    return TingkatResiden::all();
  }

  public function createData(CreateTingkatResidenRequest $createTingkatResidenRequest)
  {
    return TingkatResiden::create([
      'kd' => $createTingkatResidenRequest->input("kd"),
      'nm' => $createTingkatResidenRequest->input("nm"),
      "warna" => $createTingkatResidenRequest->input("warna"),
      "darisemester" => $createTingkatResidenRequest->input("darisemester"),
      "sampaisemester" => $createTingkatResidenRequest->input("sampaisemester"),
      "aktif" => $createTingkatResidenRequest->input("aktif")
    ]);
  }

  public function updateData(UpdateTingkatResidenRequest $updateTingkatResidenRequest, $tingkatResidenId)
  {
    $tingkatResiden = TingkatResiden::findOrFail($tingkatResidenId);

    $tingkatResiden->kd = $updateTingkatResidenRequest->input("kd");
    $tingkatResiden->nm = $updateTingkatResidenRequest->input("nm");
    $tingkatResiden->warna = $updateTingkatResidenRequest->input("warna");
    $tingkatResiden->darisemester = $updateTingkatResidenRequest->input("darisemester");
    $tingkatResiden->sampaisemester = $updateTingkatResidenRequest->input("sampaisemester");
    $tingkatResiden->aktif = $updateTingkatResidenRequest->input("aktif");
    $tingkatResiden->save();

    return $tingkatResiden;
  }

  public function checkIfAlreadyHaveResident($tingkatResidenId)
  {
    return TingkatResiden::findOrFail($tingkatResidenId)->residen()->exists();
  }

  public function deleteData($tingkatResidenId)
  {
    return TingkatResiden::findOrFail($tingkatResidenId)->delete();
  }
}
