<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page.pengumuman.index', [
            'type_menu' => 'setting',
            'pengumuman' => Pengumuman::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.pengumuman.create', [
            'type_menu' => 'setting',
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
            'tglbuat' => 'required|date',
            'tglberlaku' => 'required|date',
            'judul' => 'required',
            'pengumuman' => 'required',
        ]);

        try {
            Pengumuman::create([
                'tglbuat' => $request->tglbuat,
                'tglsampai' => $request->tglberlaku,
                'judul' => $request->judul,
                'catatan' => $request->pengumuman,
                'aktif' => $request->aktif ? 1 : 0,
                'addedbyfk' => auth()->user()->pk,
                'lastuserfk' => auth()->user()->pk,
            ]);

            return redirect()
                ->route('pengumuman.index')
                ->with('success', __('message.success_pengumuman_added'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi Kesalahan: ' . $th->getMessage());
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
        $pengumuman = Pengumuman::findOrFail($id);
        return view('page.pengumuman.edit', [
            'type_menu' => 'setting',
            'pengumuman' => $pengumuman,
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
        $pengumuman = Pengumuman::findOrFail($id);
        try {
            $pengumuman->update([
                'tglbuat' => $request->tglbuat,
                'tglsampai' => $request->tglberlaku,
                'judul' => $request->judul,
                'catatan' => $request->pengumuman,
                'aktif' => $request->aktif ? 1 : 0,
                'lastuserfk' => auth()->user()->pk,
            ]);

            return redirect()
                ->route('pengumuman.index')
                ->with('success', __('message.success_pengumuman_edit'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi Kesalahan: ' . $th->getMessage());
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
        $pengumuman = Pengumuman::findOrFail($id);
        try {
            $pengumuman->delete();
            return redirect()
                ->route('pengumuman.index')
                ->with('success', __('message.success_pengumuman_deleted'));
        } catch (\Throwable $th) {
            return back()
                ->with('error', 'Terjadi Kesalahan: ' . $th->getMessage());
        }
    }
}
