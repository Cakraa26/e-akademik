<?php

namespace App\Services\TingkatResiden;

use App\Http\Requests\TingkatResiden\CreateTingkatResidenRequest;
use App\Http\Requests\TingkatResiden\UpdateTingkatResidenRequest;
use LaravelEasyRepository\BaseService;

interface TingkatResidenService extends BaseService
{

    public function getAll();
    public function createData(CreateTingkatResidenRequest $createTingkatResidenRequest);
    public function updateData(UpdateTingkatResidenRequest $updateTingkatResidenRequest, $tingkatResidenId);
    public function checkIfAlreadyHaveResident($tingkatResidenId);
    public function deleteData($tingkatResidenId);
}
