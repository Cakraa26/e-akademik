<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class DaftarAbsensi extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'afektif';

        $thnajaran = TahunAjaran::select('pk', 'nm', 'aktif')->get();

        $selectTahunAjaran = null;
        if ($request->thnajaranfk) {
            $selectTahunAjaran = TahunAjaran::where('pk', $request->thnajaranfk)->first();
        } else {
            $selectTahunAjaran = TahunAjaran::where('aktif', 1)->first();
        }

        $residen = Residen::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->where('thnajaranfk', $selectTahunAjaran->pk);
        })
            ->when($request->semester != null, function ($q) use ($request) {
                return $q->where('semester', $request->semester);
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })
            ->get();

        $bulans = [
            $selectTahunAjaran->bulan1,
            $selectTahunAjaran->bulan2,
            $selectTahunAjaran->bulan3,
            $selectTahunAjaran->bulan4,
            $selectTahunAjaran->bulan5,
            $selectTahunAjaran->bulan6,
        ];

        $alpaCounts = [];
        foreach ($residen as $r) {
            $alpaCounts[$r->pk] = [];
            foreach ($bulans as $bulan) {
                $monthYear = Carbon::createFromFormat('Y-m', $bulan);
                $month = $monthYear->format('m');
                $year = $monthYear->format('Y');

                $count = Absen::where('residenfk', $r->pk)
                    ->whereMonth('check_in', $month)
                    ->whereYear('check_in', $year)
                    ->sum('alpa');

                $alpaCounts[$r->pk][$bulan] = $count;
            }
        }

        $semester = Semester::all();
        $thnajaran = TahunAjaran::all();
        $tingkat = Tingkat::all();
        return view("page.daftar-absensi.index", [
            'residen' => $residen,
            'bulans' => $bulans,
            'alpaCounts' => $alpaCounts,
            'semester' => $semester,
            'thnajaran' => $thnajaran,
            'tingkat' => $tingkat,
            'type_menu' => $type_menu,
        ]);
    }
    public function detail($pk, $bulan)
    {
        $type_menu = 'afektif';

        $residen = Residen::findOrFail($pk);

        $monthYear = Carbon::createFromFormat('Y-m', $bulan);
        $month = $monthYear->format('m');
        $year = $monthYear->format('Y');

        $absen = Absen::where('residenfk', $pk)
        ->whereMonth('check_in', $month)
        ->whereYear('check_in', $year)
        ->get();

        return view("page.daftar-absensi.detail", [
            'absen' => $absen,
            'residen' => $residen,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $absen = Absen::findOrFail($pk);

        try {
            $alpa = $request->has('alpa') ? 1 : 0;
            $hadir = $alpa === 1 ? 0 : 1;

            $inputData = $request->all();
            $inputData['alpa'] = $alpa;
            $inputData['hadir'] = $hadir;

            $absen->update($inputData);

            return redirect()
                ->back()
                ->with('success', __('message.success_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $absen = Absen::findOrFail($pk);
            $absen->delete();

            return redirect()
                ->back()
                ->with('success', __('message.success_deleted'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
