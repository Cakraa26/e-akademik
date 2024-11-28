<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\HariKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriKehadiran extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'historikehadiran';
        $kehadiran = 0;
        $alpa = 0;
        $terlambat = 0;

        $query = Absen::where('residenfk', auth()->user()->pk)
            ->when($request->start_date != null && $request->end_date != null, function ($q) use ($request) {
                return $q->whereBetween(DB::raw('DATE(check_in)'), [$request->start_date, $request->end_date]);
            });

        $data = $query->get();
        $alpa = clone $query;
        $alpa = $alpa->where('alpa', 1)->count();

        $kehadiran = clone $query;
        $kehadiran = $kehadiran->where('hadir', 1)->count();

        $terlambat = $data->sum('terlambat');

        return view("residen.histori-kehadiran.index", [
            'data' => $data,
            'kehadiran' => $kehadiran,
            'terlambat' => $terlambat,
            'alpa' => $alpa,
            'type_menu' => $type_menu,
        ]);
    }
}
