<?php

namespace App\Http\Controllers;

use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\KaryaIlmiah;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\KaryaIlmiahData;
use Illuminate\Support\Facades\DB;

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
                    $q2->where('semester', $request->semester);
                });
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->whereHas('residen', function ($q2) use ($request) {
                    $q2->where('tingkatfk', $request->tingkatfk);
                });
            })
            ->with('residen')
            ->get();

        $tingkat = Tingkat::all();
        $semester = Semester::all();
        return view("page.karyailmiah-residen.index", [
            'thnajaran' => $thnajaran,
            'selectTahunAjaran' => $selectTahunAjaran,
            'tingkat' => $tingkat,
            'semester' => $semester,
            'tkaryailmiah' => $tkaryailmiah,
            'type_menu' => $type_menu,
        ]);
    }
    public function edit($pk)
    {
        $type_menu = 'karyailmiah';
        $tkaryailmiah = KaryaIlmiahData::findOrFail($pk);
        $residenfk = $tkaryailmiah->residenfk;

        $karya = DB::table('m_karyailmiah')
            ->leftJoin('t_karyailmiah', function ($join) use ($residenfk) {
                $join->on('m_karyailmiah.pk', '=', 't_karyailmiah.karyailmiahfk')
                    ->where('t_karyailmiah.residenfk', '=', $residenfk);
            })
            ->leftJoin('m_tingkat', 't_karyailmiah.tingkatfk', '=', 'm_tingkat.pk')
            ->select(
                't_karyailmiah.pk as t_karyailmiah_pk',
                'm_karyailmiah.pk as karyailmiahpk',
                't_karyailmiah.residenfk',
                'm_karyailmiah.nm',
                't_karyailmiah.stssudah',
                't_karyailmiah.ctnfile',
                't_karyailmiah.uploadfile as file',
                't_karyailmiah.semester',
                'm_tingkat.kd as tingkat'
            )
            ->where('m_karyailmiah.aktif', 1)
            ->get();
        return view("page.karyailmiah-residen.detail", [
            'tkaryailmiah' => $tkaryailmiah,
            'karya' => $karya,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        try {
            $tkaryailmiah = KaryaIlmiahData::findOrFail($pk);
            $tkaryailmiah->ctnfile = $request->input('ctnfile', '');

            $tkaryailmiah->save();

            return redirect()
                ->back()
                ->with('success', __('message.success_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
