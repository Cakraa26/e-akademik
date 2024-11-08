<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;

class UTSController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'kognitif';
        $kelas = Kelas::when($request->semester != null, function ($q) use ($request) {
            return $q->where('semester', $request->semester);
        })
            ->when($request->thnajaranfk != null, function ($q) use ($request) {
                return $q->where('thnajaranfk', $request->thnajaranfk);
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })->get();

        $semester = Semester::all();
        $thnajaran = TahunAjaran::all();
        $tingkat = Tingkat::all();
        return view("page.uts.index", [
            'kelas' => $kelas,
            'semester' => $semester,
            'thnajaran' => $thnajaran,
            'tingkat' => $tingkat,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        $uts = Kelas::findOrFail($pk);
        try {
            $uts->mcqbenar_uts = str_replace(',', '.', $request->input('mcqbenar_uts', '0'));
            $uts->mcq_uts = $uts->mcqbenar_uts;
            $uts->osce_ped_uts = str_replace(',', '.', $request->input('osce_ped_uts', '0'));
            $uts->osce_trauma_uts = str_replace(',', '.', $request->input('osce_trauma_uts', '0'));
            $uts->osce_spine_uts = str_replace(',', '.', $request->input('osce_spine_uts', '0'));
            $uts->osce_lower_uts = str_replace(',', '.', $request->input('osce_lower_uts', '0'));
            $uts->osce_tumor_uts = str_replace(',', '.', $request->input('osce_tumor_uts', '0'));
            $uts->osce_hand_uts = str_replace(',', '.', $request->input('osce_hand_uts', '0'));

            $uts->hasil_osce_uts = round(array_sum([
                $uts->osce_ped_uts,
                $uts->osce_trauma_uts,
                $uts->osce_spine_uts,
                $uts->osce_lower_uts,
                $uts->osce_tumor_uts,
                $uts->osce_hand_uts
            ]) / 6, 2);

            $uts->uts = round(($uts->mcq_uts + $uts->hasil_osce_uts) / 2, 2);
            $persenuas = $uts->persenuas;
            $uts->persenuts = round(($uts->uts * 20) / 100, 2);
            $uts->persenstase = 0;
            $uts->totalnilai = $persenuas + $uts->persenuts + $uts->persenstase;
            $uts->hasil = $uts->uts >= 69.5 ? 'LULUS' : 'REMIDI';

            $uts->save();

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
