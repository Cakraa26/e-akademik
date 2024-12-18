<?php

namespace App\Http\Controllers;

use App\Models\GroupMotorik;
use App\Models\KategoriMotorik;
use App\Models\Motorik;
use App\Models\Residen;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\Tingkat;
use Illuminate\Http\Request;

class DatabaseResidenController extends Controller
{
    public function index(Request $request)
    {
        $angkatan = TahunAjaran::select('pk', 'nm', 'aktif')->get();

        $selectTahunAjaran = null;
        if ($request->thnajaranfk) {
            $selectTahunAjaran = TahunAjaran::where('pk', $request->thnajaranfk)->first();
        } else {
            $selectTahunAjaran = TahunAjaran::where('aktif', 1)->first();
        }

        $dataresiden = Residen::when($selectTahunAjaran, function ($query) use ($selectTahunAjaran) {
            return $query->where('thnajaranfk', $selectTahunAjaran->pk);
        })
            ->when($request->statuskuliah != null, function ($q) use ($request) {
                if ($request->statuskuliah == 'semua') {
                    return $q;
                }
                return $q->where('statuskuliah', $request->statuskuliah);
            })->when($request->semester != null, function ($q) use ($request) {
                return $q->where('semester', $request->semester);
            })->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })
            ->get();
        return view('page.database-residen.index', [
            'type_menu' => 'master-data',
            'motorik' => Motorik::all(),
            'semester' => Semester::all(),
            'tingkat' => Tingkat::all(),
            'angkatan' => $angkatan,
            'dataresiden' => $dataresiden,
        ]);
    }
    public function show($id)
    {
        return view('page.database-residen.show', [
            'type_menu' => 'master-data',
            'residen' => Residen::findOrFail($id),
        ]);
    }
    public function edit($id)
    {
        return view('page.database-residen.edit', [
            'type_menu' => 'master-data',
            'residen' => Residen::findOrFail($id),
        ]);
    }
    public function update(Request $request, $pk)
    {
        $residen = Residen::findOrFail($pk);

        $request->validate([
            'inisialresiden' => 'required|unique:m_residen,inisialresiden,' . $residen->pk . ',pk',
            'ktp' => 'required|unique:m_residen,ktp,' . $residen->pk . ',pk',
            'hp' => 'required|unique:m_residen,hp,' . $residen->pk . ',pk',
        ]);

        try {
            $inputData = $request->all();

            $residen->update($inputData);

            return redirect()
                ->route('database.residen.index')
                ->with('success', __('message.success_residen_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
