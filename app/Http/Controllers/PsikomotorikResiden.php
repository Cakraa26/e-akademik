<?php

namespace App\Http\Controllers;

use App\Models\Psikomotorik;
use Illuminate\Http\Request;
use App\Models\KategoriMotorik;
use App\Models\MotorikTransaction;
use App\Models\SubKategoriMotorik;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PsikomotorikResiden extends Controller
{
    public function index()
    {
        $type_menu = 'kognitif';
        $motorik = Psikomotorik::with(['subkategori', 't_motorik'])
            ->orderBy('subkategorifk', 'asc')
            ->get()
            ->groupBy('subkategorifk');
        $kategori = KategoriMotorik::all();
        $subkategori = SubKategoriMotorik::all();

        return view("residen.psikomotorik.index", [
            'motorik' => $motorik,
            'kategori' => $kategori,
            'subkategori' => $subkategori,
            'type_menu' => $type_menu,
        ]);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $residenId = auth()->user()->pk;
            $motorikId = $request->motorikpk;
            $motorikTransaction = MotorikTransaction::where('motorikfk', $motorikId)->where('residenfk', $residenId)->first();

            if (!$motorikTransaction) {
                $motorikTransaction = MotorikTransaction::create([
                    'motorikfk' => $motorikId,
                    'residenfk' => $residenId,
                    'qtymandiri' => $request->status == 0 ? 1 : 0,
                    'qtybimbingan' => $request->status == 1 ? 1 : 0,
                    'stsmandiri' => $request->status == 0 ? 1 : 0,
                    'stsbimbingan' => $request->status == 1 ? 1 : 0,
                ]);
            } else {
                $motorikTransaction->qtymandiri = $request->status == 0 ? $motorikTransaction->qtymandiri + 1 : $motorikTransaction->qtymandiri;
                $motorikTransaction->qtybimbingan = $request->status == 1 ? $motorikTransaction->qtybimbingan + 1 : $motorikTransaction->qtybimbingan;
                if ($request->status == 0) {
                    $motorikTransaction->stsmandiri = 1;
                } else if ($request->status == 1) {
                    $motorikTransaction->stsbimbingan = 1;
                }
                $motorikTransaction->save();
            }

            $file = Storage::disk('public')->put('motorik-residen', $request->file('fileMotorik'));

            $motorikTransaction->motorikData()->create([
                'residenfk' => $residenId,
                'motorikfk' => $motorikId,
                'tgl' => now()->format('Y-m-d H:i:s'),
                'nmfile' => $file,
                'stsmandiri' => $request->status == 0 ? 1 : 0,
                'stsbimbingan' => $request->status == 1 ? 1 : 0,
                'stsapproved' => 1,
                'semester' => auth()->user()->semester,
                'tingkatfk' => auth()->user()->tingkatfk,
            ]);

            DB::commit();

            return redirect()
                ->route('psikomotorik.index')
                ->with('success', __('message.success_file_uploaded'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function edit($pk){
        $type_menu = 'kognitif';
        $tmotorik = MotorikTransaction::find($pk);
        return view("residen.psikomotorik.detail", [
            'tmotorik' => $tmotorik,
            'type_menu' => $type_menu,
        ]);
    }
}
