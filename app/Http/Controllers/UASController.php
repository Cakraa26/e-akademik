<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class UASController extends Controller
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

        $kelas = Kelas::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->where('thnajaranfk', $selectTahunAjaran->pk);
        })
            ->when($request->semester != null, function ($q) use ($request) {
                return $q->where('semester', $request->semester);
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })->get();

        $semester = Semester::all();
        $tingkat = Tingkat::all();
        return view("page.uas.index", [
            'kelas' => $kelas,
            'semester' => $semester,
            'thnajaran' => $thnajaran,
            'tingkat' => $tingkat,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $semesterValue = [
            1 => 2.5,
            2 => 2.5,
            3 => 2,
            4 => 1.75,
            5 => 1.75,
            6 => 1.75,
            7 => 1,
            8 => 1,
            9 => 1
        ];

        $uas = Kelas::findOrFail($pk);
        try {
            $mcqbenar = str_replace(',', '.', $request->input('mcqbenar_uas', '0'));
            $multiMcqBenar = $mcqbenar * $semesterValue[$uas->semester];

            $uas->mcqbenar_uas = $multiMcqBenar;
            $uas->mcq_uas = $multiMcqBenar;
            $uas->osce_ped_uas = str_replace(',', '.', $request->input('osce_ped_uas', '0'));
            $uas->osce_trauma_uas = str_replace(',', '.', $request->input('osce_trauma_uas', '0'));
            $uas->osce_spine_uas = str_replace(',', '.', $request->input('osce_spine_uas', '0'));
            $uas->osce_lower_uas = str_replace(',', '.', $request->input('osce_lower_uas', '0'));
            $uas->osce_tumor_uas = str_replace(',', '.', $request->input('osce_tumor_uas', '0'));
            $uas->osce_hand_uas = str_replace(',', '.', $request->input('osce_hand_uas', '0'));

            $uas->hasil_osce_uas = round(array_sum([
                $uas->osce_ped_uas,
                $uas->osce_trauma_uas,
                $uas->osce_spine_uas,
                $uas->osce_lower_uas,
                $uas->osce_tumor_uas,
                $uas->osce_hand_uas
            ]) / 6, 2);

            $uas->uas = round(($uas->mcq_uas + $uas->hasil_osce_uas) / 2, 2);
            $uas->persenuas = round(($uas->uas * 20) / 100, 2);
            $persenuts = $uas->persenuts;
            $uas->persenstase = 0;
            $uas->totalnilai = $uas->persenuas + $persenuts + $uas->persenstase;
            $uas->hasil = $uas->totalnilai >= 69.5 ? 'LULUS' : 'REMIDI';

            $uas->save();

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
