<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KategoriMotorik;
use App\Models\SubKategoriMotorik;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function getMotorikKategori()
    {
        try {
            $data = KategoriMotorik::where("aktif", 1)->get();

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function getMotorikSubKategori()
    {
        try {
            $data = SubKategoriMotorik::where("aktif", 1)->get();

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function getTahunAjaran()
    {
        try {
            $data = TahunAjaran::all();

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
