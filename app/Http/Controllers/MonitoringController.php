<?php

namespace App\Http\Controllers;

use App\Models\MotorikTransactionData;
use App\Models\Residen;
use App\Models\Tingkat;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\GroupMotorik;
use App\Models\Psikomotorik;
use Illuminate\Http\Request;
use App\Models\KategoriMotorik as Kategori;
use App\Models\MotorikTransaction as t_motorik;
use App\Models\MotorikTransactionData as t_motorik_dt;

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
    public function approve($pk, $residenfk)
    {
        $type_menu = 'psikomotorik';
        $tingkat = Tingkat::select('pk', 'nm')->get();
        $tmotorik = t_motorik::with([
            'motorikData' => function ($query) use ($residenfk) {
                $query->where('residenfk', $residenfk);
            }
        ])->findOrFail($pk);
        $tmotorik_dt = $tmotorik->motorikData->first();
        $group = GroupMotorik::select('pk', 'nm')->get();
        $kategori = Kategori::select('pk', 'nm')->get();

        return view("page.monitoring-motorik.approve", [
            'type_menu' => $type_menu,
            'tingkat' => $tingkat,
            'tmotorik' => $tmotorik,
            'tmotorik_dt' => $tmotorik_dt,
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
    public function update(Request $request)
    {
        $stsapproved_dt = $request->input('stsapproved');
        $ctn_dt = $request->input('ctn');

        try {
            foreach ($stsapproved_dt as $pk => $stsapproved) {
                $tmotorik_dt = MotorikTransactionData::findOrFail($pk);
        
                $tmotorik_dt->stsapproved = $stsapproved;
                $tmotorik_dt->ctn = $ctn_dt[$pk];
        
                $tmotorik_dt->save();
            }

            return redirect()
                ->route('monitoring.detail', $tmotorik_dt->residen->pk)
                ->with('success', __('message.success_edit'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
