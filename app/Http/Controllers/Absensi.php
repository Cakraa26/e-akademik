<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Absensi extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'afektif';

        $absen = Absen::when($request->thnajaranfk != null, function ($q) use ($request) {
            return $q->whereHas('residen', function ($thnajaranfk) use ($request) {
                $thnajaranfk->where('thnajaranfk', $request->thnajaranfk);
            });
        })
            ->when($request->semester != null, function ($q) use ($request) {
                return $q->where('semester', $request->semester);
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })
            ->when($request->check_in != null && $request->check_out != null, function ($q) use ($request) {
                return $q->whereBetween(DB::raw('DATE(check_in)'), [$request->check_in, $request->check_out])
                    ->orWhereBetween(DB::raw('DATE(check_out)'), [$request->check_in, $request->check_out]);
            })
            ->get();
        $semester = Semester::all();
        $thnajaran = TahunAjaran::all();
        $tingkat = Tingkat::all();
        return view("page.absensi.index", [
            'absen' => $absen,
            'semester' => $semester,
            'thnajaran' => $thnajaran,
            'tingkat' => $tingkat,
            'type_menu' => $type_menu,
        ]);
    }
    public function create()
    {
        $type_menu = 'afektif';
        $residen = Residen::all();
        return view("page.absensi.create", [
            'type_menu' => $type_menu,
            'residen' => $residen,
        ]);
    }
    public function store(Request $request)
    {
        try {
            $residen = Residen::where('pk', $request->residenfk)
            ->select('tingkatfk', 'semester')
            ->first();

            $alpa = $request->has('alpa') ? 1 : 0;
            $hadir = $alpa === 1 ? 0 : 1;

            $inputData = $request->all();
            $inputData['tingkatfk'] = $residen->tingkatfk;
            $inputData['semesterfk'] = $residen->semester;
            $inputData['loc_in'] = $request->input('coordinates');
            $inputData['loc_out'] = $request->input('coordinates');
            $inputData['alpa'] = $alpa;
            $inputData['hadir'] = $hadir;

            Absen::create($inputData);

            return redirect()
                ->route('absensi.index')
                ->with('success', __('message.success_absensi_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk)
    {
        $type_menu = 'afektif';
        $absen = Absen::findOrFail($pk);
        $residen = Residen::all();
        return view("page.absensi.edit", [
            'type_menu' => $type_menu,
            'residen' => $residen,
            'absen' => $absen,
        ]);
    }
    public function update(Request $request, $pk)
    {
        try {
            $absen = Absen::findOrFail($pk);

            $residen = Residen::where('pk', $request->residenfk)
            ->select('tingkatfk', 'semester')
            ->first();

            $alpa = $request->has('alpa') ? 1 : 0;
            $hadir = $alpa === 1 ? 0 : 1;

            $inputData = $request->all();
            $inputData['tingkatfk'] = $residen->tingkatfk;
            $inputData['semesterfk'] = $residen->semester;
            $inputData['loc_in'] = $request->input('coordinates');
            $inputData['loc_out'] = $request->input('coordinates');
            $inputData['alpa'] = $alpa;
            $inputData['hadir'] = $hadir;

            $absen->update($inputData);

            return redirect()
                ->route('absensi.index')
                ->with('success', __('message.success_absensi_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        try {
            $absen = Absen::findOrFail($pk);
            $absen->delete();

            return redirect()
                ->route('absensi.index')
                ->with('success', __('message.success_absensi_hapus'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
