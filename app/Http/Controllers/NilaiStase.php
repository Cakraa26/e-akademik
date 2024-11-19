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

        $jadwal = JadwalTransaction::where('thnajaranfk', $selectTahunAjaran->pk)
            ->whereHas('residen', function ($query) use ($request) {
                $query->where('nm', 'like', '%' . $request->nm . '%');
            })
            ->when($request->semester, function ($query) use ($request) {
                $query->where('semester', $request->semester);
            })
            ->when($request->tingkatfk, function ($query) use ($request) {
                $query->where('tingkatfk', $request->tingkatfk);
            })
            ->with(['residen', 'nilai'])
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
    public function edit($pk)
    {
        $type_menu = 'kognitif';

        $jadwalNilai = JadwalTransactionNilai::with('jadwal')
            ->findOrFail($pk);

        $jadwal = $jadwalNilai->jadwal;
        $residenfk = $jadwal->residenfk;

        $jadwals = JadwalTransaction::with(['nilai.stase', 'nilai.dosen'])
            ->where('residenfk', $residenfk)
            ->get();

        $grup = collect();

        foreach ($jadwals as $jadwal) {
            $bulan = $jadwal->bulan;
            $tahun = $jadwal->tahun;

            $grup = $grup->merge(
                $jadwal->nilai->groupBy(function ($item) use ($bulan, $tahun) {
                    return $bulan . '-' . $tahun;
                })
            );
        }

        $kelas = Kelas::where('residenfk', $residenfk)->first();
        return view("page.nilai-stase.edit", [
            'jadwal' => $jadwal,
            'grup' => $grup,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kelas' => $kelas,
            'type_menu' => $type_menu,
        ]);
    }
}
