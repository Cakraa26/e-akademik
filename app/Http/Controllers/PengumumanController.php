<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Residen;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    use NotificationTrait;

    public function index()
    {
        return view('page.pengumuman.index', [
            'type_menu' => 'setting',
            'pengumuman' => Pengumuman::all(),
        ]);
    }
    public function create()
    {
        return view('page.pengumuman.create', [
            'type_menu' => 'setting',
        ]);
    }
    public function store(Request $request)
    {
        try {
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;
            $inputData['addedbyfk'] = auth()->user()->pk;
            $inputData['lastuserfk'] = auth()->user()->pk;

            $pengumuman = Pengumuman::create($inputData);
            $residen = Residen::where('aktif', 1)->whereNotNull('notif_token')->get();

            if($pengumuman->aktif)
                $this->sendMessage($residen, $pengumuman->judul, $pengumuman->catatan, [], $pengumuman->pk);

            return redirect()
                ->route('pengumuman.index')
                ->with('success', __('message.success_pengumuman_added'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi Kesalahan: ' . $th->getMessage());
        }
    }
    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('page.pengumuman.edit', [
            'type_menu' => 'setting',
            'pengumuman' => $pengumuman,
        ]);
    }
    public function update(Request $request, $id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);

            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;
            $inputData['lastuserfk'] = auth()->user()->pk;

            $pengumuman->update($inputData);

            return redirect()
                ->route('pengumuman.index')
                ->with('success', __('message.success_pengumuman_edit'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi Kesalahan: ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);
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
