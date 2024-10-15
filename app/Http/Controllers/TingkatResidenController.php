<?php

namespace App\Http\Controllers;

use App\Models\TingkatResiden;
use Illuminate\Http\Request;

class TingkatResidenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_menu = 'setting';
        $tingkat_resident = TingkatResiden::all();
        return view('page.tingkat-residen.index', [
            'type_menu' => $type_menu,
            'residen' => $tingkat_resident,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type_menu = 'setting';
        $warna = [
            'Merah',
            'Hijau',
            'Kuning',
            'Biru',
            'Putih',
            'Ungu',
        ];
        return view('page.tingkat-residen.create', [
            'type_menu' => $type_menu,
            'warna' => $warna,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kd' => 'required|unique:m_tingkat,kd',
            'nm' => 'required',
            'darisemester' => 'required|numeric',
            'sampaisemester' => 'required|numeric',
            'warna' => 'required|in:Merah,Hijau,Kuning,Biru,Putih,Ungu',
        ], [
            'kd.required' => __('message.kdrequired'),
            'kd.unique' => __('message.kdunique'),
            'nm.required' => __('message.nmrequired'),
            'darisemester.required' => __('message.drsemesterrequired'),
            'darisemester.numeric' => __('message.drsemesternumeric'),
            'sampaisemester.required' => __('message.btssemesterrequired'),
            'sampaisemester.numeric' => __('message.btssemesternumeric'),
            'warna.required' => __('message.warnarequired'),
            'warna.in' => __('message.warna_in'),
        ]);

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;
            TingkatResiden::create([
                'kd' => $inputData['kd'],
                'nm' => $inputData['nm'],
                'warna' => $inputData['warna'],
                'darisemester' => $inputData['darisemester'],
                'sampaisemester' => $inputData['sampaisemester'],
                'aktif' => $inputData['aktif'],
            ]);

            return redirect()->route('tingkat.residen.index')
                ->with('success', __('message.success_residen_added'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('page.tingkat-residen.edit', [
            'type_menu' => 'setting',
            'residen' => TingkatResiden::findOrFail($id),
            'warna' => [
                'Merah',
                'Hijau',
                'Kuning',
                'Biru',
                'Putih',
                'Ungu',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $residen = TingkatResiden::findOrFail($id);

        $request->validate([
            'kd' => 'required|unique:m_tingkat,kd,' . $residen->kd . ',kd',
            'nm' => 'required',
            'darisemester' => 'required|numeric',
            'sampaisemester' => 'required|numeric',
            'warna' => 'required|in:Merah,Hijau,Kuning,Biru,Putih,Ungu',
        ], [
            'kd.required' => __('message.kdrequired'),
            'kd.unique' => __('message.kdunique'),
            'nm.required' => __('message.nmrequired'),
            'darisemester.required' => __('message.drsemesterrequired'),
            'darisemester.numeric' => __('message.drsemesternumeric'),
            'sampaisemester.required' => __('message.btssemesterrequired'),
            'sampaisemester.numeric' => __('message.btssemesternumeric'),
            'warna.required' => __('message.warnarequired'),
            'warna.in' => __('message.warna_in'),
        ]);

        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;

            $residen->update([
                'kd' => $inputData['kd'],
                'nm' => $inputData['nm'],
                'warna' => $inputData['warna'],
                'darisemester' => $inputData['darisemester'],
                'sampaisemester' => $inputData['sampaisemester'],
                'aktif' => $inputData['aktif'],
            ]);

            return redirect()->route('tingkat.residen.index')
                ->with('success', __('message.success_residen_edit'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tingkat_residen = TingkatResiden::findOrFail($id);

            if($tingkat_residen->residen()->exists()) {
                return back()
                    ->with('error', 'Tingkat residen tidak bisa dihapus karena masih digunakan.');
            }

            $tingkat_residen->residen()->delete();

            $tingkat_residen->delete();

            return redirect()->route('tingkat.residen.index')
                ->with('success', __('message.success_residen_hapus'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
