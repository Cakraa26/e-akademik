<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Residen;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index()
    {
        $type_menu = "master-data";
        $residen = Residen::where('statuskuliah', '0')
            ->where('aktif', 0)
            ->get();

        $count = Residen::where('statuskuliah', 0)
            ->where('aktif', 0)
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
    public function update($pk)
    {
        try {
            $residen = Residen::findOrFail($pk);
            $thnajaran = TahunAjaran::where('aktif', 1)->first();

            $inputData['aktif'] = 1;
            $inputData['statuskuliah'] = 1;
            $inputData['is_approved'] = 1;
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
    public function show($pk)
    {
        $type_menu = 'master-data';
        $residen = Residen::findOrFail($pk);
        return view("page.data-mahasiswa.detail", [
            'type_menu' => $type_menu,
            'residen' => $residen,
        ]);
    }
}
