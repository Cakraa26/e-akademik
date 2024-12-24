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

        $jadwalNilai = JadwalTransactionNilai::findOrFail($pk);

        $jadwal = $jadwalNilai->jadwal;
        $residenfk = $jadwal->residenfk;

        $jadwalNilais = JadwalTransactionNilai::with(['stase', 'dosen', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($residenfk) {
                $query->where('residenfk', $residenfk);
            })
            ->get();

        $grup = $jadwalNilais->groupBy(function ($item) {
            return $item->jadwal->bulan . '-' . $item->jadwal->tahun;
        })->sortKeys();

        $kelas = Kelas::where('residenfk', $residenfk)->first();
        return view("page.nilai-stase.edit", [
            'grup' => $grup,
            'type_menu' => $type_menu,
            'jadwal' => $jadwal,
            'kelas' => $kelas,
        ]);
    }
    public function update(Request $request, $pk)
    {
        try {
            $nilai = JadwalTransactionNilai::findOrFail($pk);
            $nilai->nilai = round($request->input('nilai'), 2);
            $nilai->ctnfile = $request->input('ctnfile');
            $nilai->stsnilai = $request->has('stsnilai') ? 2 : 1;

            $nilai->save();

            $nilaistase = round($request->totalnilai, 2);
            $residenfk = $nilai->jadwal->residenfk;
            $kelas = Kelas::where('residenfk', $residenfk)->first();
            if ($kelas) {
                $kelas->nilaistase = $nilaistase;
                $kelas->save();
            }

            return redirect()
                ->route('nilai.stase.edit', $nilai->pk)
                ->with('success', __('message.success_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
