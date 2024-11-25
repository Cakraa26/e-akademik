<?php

namespace App\Http\Controllers\API\Resident;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $setting = DB::table('s_setting')->first();
            $startMonth = date('Y-m-01');
            $endMonth = date('Y-m-t');

            $query = Absen::where('residenfk', auth()->user()->pk)
                ->whereBetween('check_in', [$startMonth, $endMonth]);
            $data = $query->get();

            $alpa = clone $query;
            $alpa = $alpa->where('alpa', 1)->count();

            $kehadiran = clone $query;
            $kehadiran = $kehadiran->where('hadir', 1)->count();

            $terlambat = $data->sum('terlambat');

            return response()->json([
                'kehadiran' => $kehadiran,
                'terlambat' => $terlambat,
                'alpa' => $alpa,
                'setting' => $setting
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
