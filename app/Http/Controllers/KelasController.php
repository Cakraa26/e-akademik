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
            })
            ->when($request->search != null, function ($q) use ($request) {
                return $q->whereHas('residen', function ($search) use ($request) {
                    $search->where('nm', 'like', '%' . $request->search . '%')
                        ->orWhere('hp', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('semester', 'asc')
            ->get()
            ->groupBy('semester');

        $residen = Residen::all();
        $tingkat = Tingkat::all();
        $semester = Semester::all();

        $selectTahunAjaranPk = $request->input('select_thnajaran') ?? $selectTahunAjaran->pk;

        $residenBelumTerdaftar = Residen::where('statuskuliah', 1)
            ->whereNotIn('pk', function ($query) use ($selectTahunAjaranPk) {
                $query->select('residenfk')
                    ->from('m_kelas')
                    ->where('thnajaranfk', $selectTahunAjaranPk);
            })
            ->get();

        $semesters = Semester::select('pk', 'semester')->get();

        return view("page.data-kelas.index", [
            'kelas' => $kelas,
            'thnajaran' => $thnajaran,
            'selectTahunAjaran' => $selectTahunAjaran,
            'residenBelumTerdaftar' => $residenBelumTerdaftar,
            'tingkat' => $tingkat,
            'semester' => $semester,
            'semesters' => $semesters,
            'residen' => $residen,
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        try {
            $thnajaranfk = $request->input('select_thnajaran');
            $residen = Residen::whereIn('statuskuliah', [1, 4])->orderBy('semester', 'asc')->get();

            foreach ($residen as $r) {
                $semesterbaru = $r->semester + 1;

                $tingkat = Tingkat::where('darisemester', '<=', $semesterbaru)
                    ->where('sampaisemester', '>=', $semesterbaru)
                    ->first();

                if ($tingkat) {
                    $aktif = $r->statuskuliah == 4 ? 0 : 1;
                    $kodekelas = $thnajaranfk . $semesterbaru;

                    $kelas = Kelas::create([
                        'semester' => $semesterbaru,
                        'tingkatfk' => $tingkat->pk,
                        'aktif' => $aktif,
                        'thnajaranfk' => $thnajaranfk,
                        'residenfk' => $r->pk,
                        'tglmulai' => now(),
                        'kodekelas' => $kodekelas,
                        'ctn_semester' => '',
                        'ctn_karyailmiah' => '',
                        'ctn_tingkat' => '',
                    ]);

                    $r->update([
                        'kelasfk' => $kelas->pk,
                        'semester' => $semesterbaru,
                        'tingkatfk' => $tingkat->pk,
                        'thnajaranfk' => $thnajaranfk,
                    ]);
                }
            }

            return redirect()
                ->back()
                ->with('success', __('message.success_kelas_added'));

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function newKelas(Request $request)
    {
        try {
            $residen = Residen::find($request->residenfk);
            $semester = $request->semesters;
            $tingkat = Tingkat::where('darisemester', '<=', $semester)
                ->where('sampaisemester', '>=', $semester)
                ->first();
            $thnajaranfk = $request->input('select_thnajaran');
            $kodekelas = $thnajaranfk . $semester;
            $aktif = $residen->statuskuliah == 4 ? 0 : 1;

            $kelas = Kelas::create([
                'kodekelas' => $kodekelas,
                'thnajaranfk' => $thnajaranfk,
                'residenfk' => $residen->pk,
                'tingkatfk' => $tingkat->pk,
                'tglmulai' => now(),
                'semester' => $semester,
                'aktif' => $aktif,
                'ctn_semester' => '',
                'ctn_karyailmiah' => '',
                'ctn_tingkat' => '',
            ]);
            $residen->update([
                'kelasfk' => $kelas->pk,
                'semester' => $semester,
                'tingkatfk' => $tingkat->pk,
                'thnajaranfk' => $thnajaranfk,
            ]);

            return redirect()
                ->back()
                ->with('success', __('message.success_kelas_added'));

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
