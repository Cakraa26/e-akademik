<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KognitifResiden extends Controller
{
    public function utsIndex(Request $request)
    {
        $type_menu = 'kognitif';
        $thnajaran = TahunAjaran::select('pk', 'nm', 'aktif')->get();

        $selectTahunAjaran = null;
        if ($request->thnajaranfk) {
            $selectTahunAjaran = TahunAjaran::where('pk', $request->thnajaranfk)->first();
        } else {
            $selectTahunAjaran = TahunAjaran::where('aktif', 1)->first();
        }

        $kelas = Kelas::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->where('thnajaranfk', $selectTahunAjaran->pk);
        })
            ->where('residenfk', auth()->user()->pk)
            ->first();

        return view("residen.uts-residen.index", [
            'kelas' => $kelas,
            'thnajaran' => $thnajaran,
            'selectTahunAjaran' => $selectTahunAjaran,
            'type_menu' => $type_menu,
        ]);
    }
    public function uasIndex(Request $request)
    {
        $type_menu = 'kognitif';
        $thnajaran = TahunAjaran::select('pk', 'nm', 'aktif')->get();

        $selectTahunAjaran = null;
        if ($request->thnajaranfk) {
            $selectTahunAjaran = TahunAjaran::where('pk', $request->thnajaranfk)->first();
        } else {
            $selectTahunAjaran = TahunAjaran::where('aktif', 1)->first();
        }

        $kelas = Kelas::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->where('thnajaranfk', $selectTahunAjaran->pk);
        })
            ->where('residenfk', auth()->user()->pk)
            ->first();

        return view("residen.uas-residen.index", [
            'kelas' => $kelas,
            'thnajaran' => $thnajaran,
            'selectTahunAjaran' => $selectTahunAjaran,
            'type_menu' => $type_menu,
        ]);
    }
}
