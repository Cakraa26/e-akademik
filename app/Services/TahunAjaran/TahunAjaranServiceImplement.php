<?php

namespace App\Services\TahunAjaran;

use App\Http\Requests\TahunAjaran\CreateTahunAjaranRequest;
use App\Http\Requests\TahunAjaran\UpdateTahunAjaranRequest;
use App\Models\TahunAjaran;
use LaravelEasyRepository\Service;

class TahunAjaranServiceImplement extends Service implements TahunAjaranService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(TahunAjaran $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function getAll()
  {
    return TahunAjaran::all();
  }

  public function createData(CreateTahunAjaranRequest $createTahunAjaranRequest)
  {
    return TahunAjaran::create([
      'nm' => $createTahunAjaranRequest->input("nm"),
      "ctn" => $createTahunAjaranRequest->input("ctn"),
      "aktif" => $createTahunAjaranRequest->input("aktif")
    ]);
  }

  public function updateData(UpdateTahunAjaranRequest $updateTahunAjaranRequest, $tahunAjaranId)
  {
    $tahunAjaran = TahunAjaran::findOrFail($tahunAjaranId);

    $tahunAjaran->nm = $updateTahunAjaranRequest->input("nm");
    $tahunAjaran->ctn = $updateTahunAjaranRequest->input("ctn");
    $tahunAjaran->aktif = $updateTahunAjaranRequest->input("aktif");

    $tahunAjaran->save();

    return $tahunAjaran;
  }

  public function checkTahunAjaranAlreadyHaveClass($tahunAjaranId)
  {
    return TahunAjaran::findOrFail($tahunAjaranId)->kelas()->exists();
  }

  public function deleteData($tahunAjaranId)
  {
    return TahunAjaran::findOrFail($tahunAjaranId)->delete();
  }
}
