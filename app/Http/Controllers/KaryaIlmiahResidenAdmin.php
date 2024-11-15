<?php

namespace App\Http\Controllers;

use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\KaryaIlmiah;
use App\Models\KaryaIlmiahData;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KaryaIlmiahResidenAdmin extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'karyailmiah';
        $thnajaran = TahunAjaran::select('pk', 'nm', 'aktif')->get();

        $selectTahunAjaran = null;
        if ($request->thnajaranfk) {
            $selectTahunAjaran = TahunAjaran::where('pk', $request->thnajaranfk)->first();
        } else {
            $selectTahunAjaran = TahunAjaran::where('aktif', 1)->first();
        }

        $tkaryailmiah = KaryaIlmiahData::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->whereHas('residen', function ($q) use ($selectTahunAjaran) {
                $q->where('thnajaranfk', $selectTahunAjaran->pk);
            });
        })
            ->when($request->semester != null, function ($q) use ($request) {
                return $q->whereHas('residen', function ($q2) use ($request) {
                    $q2->where('semester', $request->semester); // Filter berdasarkan semester di tabel m_residen
                });
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->whereHas('residen', function ($q2) use ($request) {
                    $q2->where('tingkatfk', $request->tingkatfk); // Filter berdasarkan tingkatfk di tabel m_residen
                });
            })
            ->with('residen')
            ->get();

        $tingkat = Tingkat::all();
        $semester = Semester::all();
        return view("page.karya-ilmiah-residen.index", [
            'thnajaran' => $thnajaran,
            'selectTahunAjaran' => $selectTahunAjaran,
            'tingkat' => $tingkat,
            'semester' => $semester,
            'tkaryailmiah' => $tkaryailmiah,
            'type_menu' => $type_menu,
        ]);
    }
}
