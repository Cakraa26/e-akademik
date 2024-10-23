<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'master-data';
        $thnajaranAktif = TahunAjaran::where('aktif', 1)->first();
        $tahunAjaranFilter = $request->input('thnajaranfk', $thnajaranAktif ? $thnajaranAktif->pk : null);
        $kelas = Kelas::when($tahunAjaranFilter != null, function ($q) use ($tahunAjaranFilter) {
            return $q->where('thnajaranfk', $tahunAjaranFilter);
        })->get();
        // $thnajaran = TahunAjaran::find($tahunAjaranFilter);
        // if($thnajaran){

        // }
        $aktif = Kelas::where('thnajaranfk', $tahunAjaranFilter)
            ->whereHas('thnajaran', function ($q) {
                $q->where('aktif', 1);
            })->exists();
        $residen = Residen::all();
        $thnajaran = TahunAjaran::all();
        $tingkat = Tingkat::all();
        $semester = Semester::all();
        return view("page.data-kelas.index", [
            'kelas' => $kelas,
            'thnajaran' => $thnajaran,
            'aktif' => $aktif,
            'tingkat' => $tingkat,
            'semester' => $semester,
            'residen' => $residen,
            'type_menu' => $type_menu,
        ]);
    }
    public function edit($pk)
    {
        $type_menu = 'master-data';
        $kelas = Kelas::findOrFail($pk);
        $residen = Residen::all();
        $thnajaran = TahunAjaran::all();
        $tingkat = Tingkat::all();
        $semester = Semester::all();
        return view("page.data-kelas.edit", [
            'kelas' => $kelas,
            'thnajaran' => $thnajaran,
            'tingkat' => $tingkat,
            'semester' => $semester,
            'residen' => $residen,
            'type_menu' => $type_menu,
        ]);
    }
    public function update(Request $request, $pk)
    {
        try {   
            $kelas = Kelas::findOrFail($pk);
            $inputData = $request->all();
            $inputData['kodekelas'] = $inputData['thnajaranfk'] . $inputData['semester'];

            $kelas->update($inputData);
            
            $kelas->residen->update([
                'semester' => $inputData['semester'],
                'tingkatfk' => $inputData['tingkatfk'],
                'thnajaranfk' => $inputData['thnajaranfk'],
            ]);

            return redirect()
                ->route('data.kelas.index')
                ->with('success', __('message.success_kelas_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
