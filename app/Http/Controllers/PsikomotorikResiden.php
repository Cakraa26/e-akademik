<?php

namespace App\Http\Controllers;

use App\Models\Psikomotorik;
use Illuminate\Http\Request;
use App\Models\KategoriMotorik;
use App\Models\MotorikTransaction;
use App\Models\SubKategoriMotorik;
use Illuminate\Support\Facades\DB;
use App\Models\MotorikTransactionData;
use Illuminate\Support\Facades\Storage;

class PsikomotorikResiden extends Controller
{
    public function index()
    {
        $type_menu = 'psikomotorik';
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
    public function edit($pk)
    {
        $type_menu = 'psikomotorik';
        $tmotorik = MotorikTransaction::with('motorik', 'motorikData')->find($pk);
        $motorikTransactionData = $tmotorik->motorikData;
        return view("residen.psikomotorik.edit", [
            'tmotorik' => $tmotorik,
            'motorikTransactionData' => $motorikTransactionData,
            'type_menu' => $type_menu,
        ]);
    }
    public function uploadDetail(Request $request)
    {
        try {
            $residenId = auth()->user()->pk;
            $motorikTransactionDataId = $request->tmotorikdt;
            $motorikId = $request->motorikpk;
            $motorikTransaction = MotorikTransaction::with(['motorikData'])->where('motorikfk', $motorikId)->where('residenfk', $residenId)->firstOrFail();
            $motorikTransactionData = $motorikTransaction->motorikData()->findOrFail($motorikTransactionDataId);

            if (Storage::disk('public')->exists($motorikTransactionData->nmfile)) {
                Storage::disk('public')->delete($motorikTransactionData->nmfile);
            }

            $motorikTransactionData->update([
                'nmfile' => Storage::disk('public')->put('motorik-residen', $request->file('fileMotorik')),
                'stsapproved' => 1
            ]);

            if ($motorikTransactionData->stsmandiri == 1) {
                $motorikTransaction->stsmandiri = 1;
            } else if ($motorikTransactionData->stsbimbingan == 1) {
                $motorikTransaction->stsbimbingan = 1;
            }
            $motorikTransaction->save();

            DB::commit();

            return redirect()
                ->route('psikomotorik.edit', $motorikTransaction->pk)
                ->with('success', __('message.success_file_uploaded'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function destroy($pk)
    {
        DB::beginTransaction();

        try {
            $motorikTransactionData = MotorikTransactionData::findOrFail($pk);
            $motorikTransaction = $motorikTransactionData->motorikTransaction;

            if (Storage::disk('public')->exists($motorikTransactionData->nmfile)) {
                Storage::disk('public')->delete($motorikTransactionData->nmfile);
            }

            if ($motorikTransactionData->stsmandiri == 1) {
                $motorikTransaction->stsmandiri = $motorikTransaction->motorikData()->where('stsmandiri', 1)->count() - 1 > 0 ? 1 : 0;
                $motorikTransaction->qtymandiri -= 1;
            } else if ($motorikTransactionData->stsbimbingan == 1) {
                $motorikTransaction->stsbimbingan = $motorikTransaction->motorikData()->where('stsbimbingan', 1)->count() - 1 > 0 ? 1 : 0;
                $motorikTransaction->qtybimbingan -= 1;
            }

            $motorikTransaction->save();
            $motorikTransactionData->delete();

            DB::commit();

            return redirect()
                ->route('psikomotorik.edit', $motorikTransaction->pk)
                ->with('success', __('message.success_deleted'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
