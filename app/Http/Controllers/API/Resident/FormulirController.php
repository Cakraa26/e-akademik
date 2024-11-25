<?php

namespace App\Http\Controllers\API\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

class FormulirController extends Controller
{
    public function getData(Request $request)
    {
        try {
            $data = File::where('nm', 'LIKE', '%' . $request->q . '%')
                ->orWhere('ctn', 'LIKE', '%' . $request->q . '%')
                ->get();

            return response()->json([
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
