<?php

namespace App\Services\TahunAjaran;

use App\Http\Requests\TahunAjaran\CreateTahunAjaranRequest;
use App\Http\Requests\TahunAjaran\UpdateTahunAjaranRequest;
use LaravelEasyRepository\BaseService;

interface TahunAjaranService extends BaseService
{

    // Write something awesome :)
    public function getAll();
    public function createData(CreateTahunAjaranRequest $createTahunAjaranRequest);
    public function updateData(UpdateTahunAjaranRequest $updateTahunAjaranRequest, $tahunAjaranId);
    public function checkTahunAjaranAlreadyHaveClass($tahunAjaranId);
    public function deleteData($tahunAjaranId);
}
