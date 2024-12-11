<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\HariKerja;
use App\Models\Pengumuman;
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

        $query = Absen::where('residenfk', auth()->user()->pk);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween(DB::raw('DATE(check_in)'), [
                $request->start_date,
                $request->end_date
            ]);
        } else {
            $query->whereMonth('check_in', now()->month)
                ->whereYear('check_in', now()->year);
        }

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
    public function dashboardResiden(Request $request)
    {
        $type_menu = 'dashboard-residen';
        $kehadiran = 0;
        $alpa = 0;
        $terlambat = 0;

        $currentMonthName = Carbon::now()->translatedFormat('F Y');

        $query = Absen::where('residenfk', auth()->user()->pk)
            ->whereMonth('check_in', now()->month)
            ->whereYear('check_in', now()->year);

        $data = $query->get();
        $alpa = clone $query;
        $alpa = $alpa->where('alpa', 1)->count();

        $kehadiran = clone $query;
        $kehadiran = $kehadiran->where('hadir', 1)->count();

        $terlambat = $data->sum('terlambat');

        $pengumuman = Pengumuman::whereDate('tglsampai', '>=', Carbon::today())
            ->orderBy('tglbuat', 'desc')
            ->get();

        return view("residen.dashboard-residen", [
            'data' => $data,
            'kehadiran' => $kehadiran,
            'currentMonthName' => $currentMonthName,
            'terlambat' => $terlambat,
            'alpa' => $alpa,
            'pengumuman' => $pengumuman,
            'type_menu' => $type_menu,
        ]);
    }
}
