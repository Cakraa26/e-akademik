<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Residen;
use App\Models\TahunAjaran;
use App\Models\GroupMotorik;
use Illuminate\Http\Request;
use App\Models\KategoriMotorik as Kategori;

class MahasiswaController extends Controller
{
    public function index()
    {
        $type_menu = "master-data";
        $residen = Residen::where('statuskuliah', '0')
            ->where('aktif', '0')
            ->get();

        $count = Residen::where('statuskuliah', 0)
            ->whereYear('dateadded', Carbon::now()->year) 
            ->count();
            
        $thnajaran = TahunAjaran::where('aktif', 1)->first();

        return view('page.data-mahasiswa.index', [
            'type_menu' => $type_menu,
            'residen' => $residen,
            'thnajaran' => $thnajaran,
            'count' => $count,
        ]);
    }
    public function show(Request $request, $id)
    {
        $residen = Residen::findOrFail($id);
        $type_menu = "master-data";
        return view('page.data-mahasiswa.detail', [
            'residen' => $residen,
            'type_menu' => $type_menu,
        ]);
    }
    public function edit($id)
    {
        //
    }
    public function update($pk)
    {
        try {
            $residen = Residen::findOrFail($pk);
            $thnajaran = TahunAjaran::where('aktif', 1)->first();

            $inputData['aktif'] = 1;
            $inputData['statuskuliah'] = 1;
            $inputData['angkatanfk'] = $thnajaran->pk;
            $inputData['thnajaranfk'] = $thnajaran->pk;

            $residen->update($inputData);

            return redirect()
                ->route('data.mahasiswa.index')
                ->with('success', __('message.success_confirm'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
