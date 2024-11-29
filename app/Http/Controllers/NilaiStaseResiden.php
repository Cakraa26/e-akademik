<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\JadwalTransactionNilai;
use Illuminate\Support\Facades\Storage;

class NilaiStaseResiden extends Controller
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

        $residenfk = auth()->user()->pk;

        $jadwalNilai = JadwalTransactionNilai::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->whereHas('jadwal', function ($query) use ($selectTahunAjaran) {
                return $query->where('thnajaranfk', $selectTahunAjaran->pk);
            });
        })
            ->with(['stase', 'dosen', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($residenfk) {
                $query->where('residenfk', $residenfk);
            })
            ->get();

        $grup = $jadwalNilai->groupBy(function ($item) {
            return $item->jadwal->bulan . '-' . $item->jadwal->tahun;
        });

        $monthNow = now()->format('m');
        $colorRed = JadwalTransactionNilai::with('jadwal')
            ->where('jadwal.bulan', '<', $monthNow)
            ->where(function ($query) {
                $query->whereNotNull('nmfile')
                    ->orWhere('stsnilai', '!=', 2);
            });

        return view("residen.nilai-stase-residen.index", [
            'grup' => $grup,
            'jadwalNilai' => $jadwalNilai,
            'thnajaran' => $thnajaran,
            'selectTahunAjaran' => $selectTahunAjaran,
            'colorRed' => $colorRed,
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        try {
            $stasefk = $request->stasefk;
            $staseNilai = JadwalTransactionNilai::findOrFail($stasefk);

            if ($staseNilai->nmfile && Storage::disk('public')->exists($staseNilai->nmfile)) {
                Storage::disk('public')->delete($staseNilai->nmfile);
            }

            $filePath = Storage::disk('public')->put('stase-residen', $request->file('fileStase'));

            $staseNilai->nmfile = $filePath;
            $staseNilai->stsnilai = 1;
            $staseNilai->save();

            return redirect()
                ->back()
                ->with('success', __('message.success_file_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
