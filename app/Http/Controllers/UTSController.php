<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Traits\NotificationTrait;

class UTSController extends Controller
{
    use NotificationTrait;

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

        $uts = Kelas::findOrFail($pk);
        try {
            $mcqbenar = str_replace(',', '.', $request->input('mcqbenar_uts', '0'));
            $multiMcqBenar = $mcqbenar * $semesterValue[$uts->semester];

            $uts->mcqbenar_uts = $multiMcqBenar;
            $uts->mcq_uts = $multiMcqBenar;
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

            // send notification
            $this->sendMessage([$uts->residen], 'UTS', 'Nilai UTS anda sudah keluar');

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
