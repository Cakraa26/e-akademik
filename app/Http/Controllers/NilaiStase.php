<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\JadwalTransaction;
use App\Models\JadwalTransactionNilai;

class NilaiStase extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'kognitif';
        $thnajaran = TahunAjaran::select('pk', 'nm', 'aktif')->get();

        $selectTahunAjaran = null;
        if ($request->thnajaranfk) {
            $selectTahunAjaran = TahunAjaran::where('pk', $request->thnajaranfk)->first();
        } else {
            $selectTahunAjaran = TahunAjaran::where('aktif', 1)->first();
        }

        $bulan = [
            $selectTahunAjaran->bulan1,
            $selectTahunAjaran->bulan2,
            $selectTahunAjaran->bulan3,
            $selectTahunAjaran->bulan4,
            $selectTahunAjaran->bulan5,
            $selectTahunAjaran->bulan6,
        ];

        $jadwal = JadwalTransaction::whereHas('nilai', function ($query) use ($selectTahunAjaran) {
            return $query->where('thnajaranfk', $selectTahunAjaran->pk);
        })
            ->when($request->semester != null, function ($q) use ($request) {
                return $q->where('semester', $request->semester);
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })
            ->orderBy('semester', 'asc')
            ->get()
            ->groupBy('semester');

        $residen = Residen::all();
        $tingkat = Tingkat::all();
        $semester = Semester::all();
        return view("page.nilai-stase.index", [
            'jadwal' => $jadwal,
            'thnajaran' => $thnajaran,
            'selectTahunAjaran' => $selectTahunAjaran,
            'tingkat' => $tingkat,
            'semester' => $semester,
            'residen' => $residen,
            'bulan' => $bulan,
            'type_menu' => $type_menu,
        ]);
    }
}
