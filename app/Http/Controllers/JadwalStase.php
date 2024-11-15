<?php

namespace App\Http\Controllers;

use App\Models\Stase;
use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\StaseDosen;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\JadwalTransaction;
use App\Models\JadwalTransactionNilai;

class JadwalStase extends Controller
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

        $residen = Residen::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->where('thnajaranfk', $selectTahunAjaran->pk);
        })
            ->when($request->semester != null, function ($q) use ($request) {
                return $q->where('semester', $request->semester);
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })
            ->when($request->nm != null, function ($q) use ($request) {
                return $q->where('nm', 'like', '%' . $request->nm . '%');
            })
            ->with([
                'jadwal' => function ($query) use ($selectTahunAjaran) {
                    $query->where('thnajaranfk', $selectTahunAjaran->pk);
                }
            ])
            ->orderBy('semester', 'asc')
            ->get()
            ->groupBy('semester');
        $jadwal = JadwalTransaction::all();
        $tingkat = Tingkat::all();
        $semester = Semester::all();
        return view("page.jadwal-stase.index", [
            'type_menu' => $type_menu,
            'residen' => $residen,
            'selectTahunAjaran' => $selectTahunAjaran,
            'bulan' => $bulan,
            'jadwal' => $jadwal,
            'thnajaran' => $thnajaran,
            'tingkat' => $tingkat,
            'semester' => $semester,
        ]);
    }
    public function edit($pk)
    {
        $type_menu = 'kognitif';
        $residen = Residen::with('jadwal')->find($pk);
        $stase = Stase::all();
        $thnajaran = TahunAjaran::find($residen->thnajaranfk);
        $bulan = [
            'bulan1' => $thnajaran->bulan1,
            'bulan2' => $thnajaran->bulan2,
            'bulan3' => $thnajaran->bulan3,
            'bulan4' => $thnajaran->bulan4,
            'bulan5' => $thnajaran->bulan5,
            'bulan6' => $thnajaran->bulan6,
        ];

        return view('page.jadwal-stase.edit', [
            'type_menu' => $type_menu,
            'residen' => $residen,
            'stase' => $stase,
            'bulan' => $bulan,
        ]);
    }
    public function store(Request $request, $pk)
    {
        try {
            $residen = Residen::with('tahunajaran')->find($pk);
            $thnajaran = $residen->tahunajaran;

            $bulan = [
                'stasefk1' => ['bulan' => substr($thnajaran->bulan1, 5, 2), 'tahun' => substr($thnajaran->bulan1, 0, 4)],
                'stasefk2' => ['bulan' => substr($thnajaran->bulan2, 5, 2), 'tahun' => substr($thnajaran->bulan2, 0, 4)],
                'stasefk3' => ['bulan' => substr($thnajaran->bulan3, 5, 2), 'tahun' => substr($thnajaran->bulan3, 0, 4)],
                'stasefk4' => ['bulan' => substr($thnajaran->bulan4, 5, 2), 'tahun' => substr($thnajaran->bulan4, 0, 4)],
                'stasefk5' => ['bulan' => substr($thnajaran->bulan5, 5, 2), 'tahun' => substr($thnajaran->bulan5, 0, 4)],
                'stasefk6' => ['bulan' => substr($thnajaran->bulan6, 5, 2), 'tahun' => substr($thnajaran->bulan6, 0, 4)],
            ];

            foreach ($bulan as $inputName => $date) {
                if ($request->filled($inputName)) {
                    $create = [
                        'thnajaranfk' => $thnajaran->pk,
                        'residenfk' => $residen->pk,
                        'semester' => $residen->semester,
                        'tingkatfk' => $residen->tingkatfk,
                        'bulan' => $date['bulan'],
                        'tahun' => $date['tahun'],
                    ];
                    
                    $update = [
                        'stasefk' => $request->input($inputName),
                    ];

                    $jadwalTransaction = JadwalTransaction::updateOrCreate($create, $update);

                    $dosen = StaseDosen::where('stasefk', $request->input($inputName))->get();

                    foreach ($dosen as $d) {
                        $create = [
                            'jadwalfk' => $jadwalTransaction->pk,
                            'dosenfk' => $d->dosenfk,
                        ];

                        $update = [
                            'stasefk' => $request->input($inputName),
                            'ctn' => '',
                            'dateadded' => now(),
                        ];

                        JadwalTransactionNilai::updateOrCreate($create, $update);
                    }
                }
            }

            return redirect()
                ->route('jadwal.stase.index')
                ->with('success', __('message.success_jadwal_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
