<?php

namespace App\Http\Controllers;

use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\KategoriMotorik as Kategori;
use App\Models\Semester;
use App\Models\MotorikTransaction as t_motorik;
use App\Models\SubKategoriMotorik as SubKategori;
use App\Models\TahunAjaran;
use Illuminate\Support\Str;
use App\Models\GroupMotorik;
use App\Models\Psikomotorik;
use App\Models\MotorikTransactionData as t_motorik_dt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'psikomotorik';
        $motorik = Psikomotorik::all();
        $semester = Semester::all();
        $thnajaran = TahunAjaran::all();
        $tingkat = Tingkat::all();
        $residen = Residen::when($request->semester != null, function ($q) use ($request) {
            return $q->where('semester', $request->semester);
        })
            ->when($request->thnajaranfk != null, function ($q) use ($request) {
                return $q->where('thnajaranfk', $request->thnajaranfk);
            })
            ->when($request->tingkatfk != null, function ($q) use ($request) {
                return $q->where('tingkatfk', $request->tingkatfk);
            })->get();
        ;

        return view("page.monitoring-motorik.index", [
            'type_menu' => $type_menu,
            'motorik' => $motorik,
            'semester' => $semester,
            'thnajaran' => $thnajaran,
            'residen' => $residen,
            'tingkat' => $tingkat,
        ]);
    }
    public function detail(Request $request, $pk)
    {
        $type_menu = 'psikomotorik';
        $residen = Residen::findOrFail($pk);
        $tmotorik = t_motorik::with('motorik', 'motorikData')
            ->where('residenfk', $residen->pk)
            ->when($request->groupfk != null, function ($q) use ($request) {
                return $q->whereHas('motorik', function ($query) use ($request) {
                    $query->where('groupfk', $request->groupfk);
                });
            })
            ->when($request->kategorifk != null, function ($q) use ($request) {
                return $q->whereHas('motorik', function ($query) use ($request) {
                    $query->where('kategorifk', $request->kategorifk);
                });
            })->get();

        $tmotorik_dt = t_motorik_dt::all();
        $tingkat = Tingkat::select('pk', 'nm')->get();
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();

        return view("page.monitoring-motorik.detail", [
            'type_menu' => $type_menu,
            'residen' => $residen,
            'tingkat' => $tingkat,
            'tmotorik' => $tmotorik,
            'tmotorik_dt' => $tmotorik_dt,
            'group' => $group,
            'kategori' => $kategori,
        ]);
    }
    public function approve(Request $request, $pk)
    {
        $type_menu = 'psikomotorik';
        $residen = Residen::all();
        $tingkat = Tingkat::select('pk', 'nm')->get();
        $tmotorik = t_motorik::with('motorik', 'motorikData')->where('pk', $pk)->findOrFail($pk);
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();

        return view("page.monitoring-motorik.approve", [
            'type_menu' => $type_menu,
            'residen' => $residen,
            'tingkat' => $tingkat,
            'tmotorik' => $tmotorik,
            'group' => $group,
            'kategori' => $kategori,
        ]);
    }
    public function approveStore(Request $request, $pk)
    {
        try {
            $tmotorik = t_motorik::findOrFail($pk);

            $inputData = $request->all();
            $inputData['t_motorik_fk'] = $tmotorik->pk;
            $inputData['residenfk'] = $tmotorik->residenfk;
            $inputData['semester'] = $tmotorik->residen->semester;
            $inputData['tingkatfk'] = $tmotorik->residen->tingkatfk;
            $inputData['motorikfk'] = $tmotorik->motorikfk;

            if ($request->hasFile('nmfile')) {
                $file = $request->file('nmfile');
                $fileName = $file->getClientOriginalName();
                $file->storeAs('public/approve', $fileName);
                $inputData['nmfile'] = $fileName;
            }

            $tmotorik_dt = t_motorik_dt::create($inputData);

            $stsbimbingan = t_motorik_dt::where('t_motorik_fk', $tmotorik_dt->t_motorik_fk)
                ->sum('stsbimbingan');
            t_motorik::where('pk', $tmotorik_dt->t_motorik_fk)
                ->update([
                    'qtybimbingan' => $stsbimbingan
                ]);

            return redirect()
                ->route('monitoring.detail', $tmotorik->residen->pk)
                ->with('success', __('message.success_approved'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
