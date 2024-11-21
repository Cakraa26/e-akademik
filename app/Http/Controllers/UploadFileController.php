<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Ramsey\Uuid\v1;

class UploadFileController extends Controller
{
    public function index()
    {
        return view('page.upload-file.index', [
            'type_menu' => 'setting',
            'files' => File::all(),
        ]);
    }
    public function create()
    {
        return view('page.upload-file.create', [
            'type_menu' => 'setting',
        ]);
    }
    public function store(Request $request)
    {
        try {
            $filePath = Storage::disk('public')->put('upload-file', $request->file('file'));
            File::create([
                'nm' => $request->nm,
                'alamatfile' => $filePath,
                'ctn' => $request->ctn,
                'aktif' => $request->aktif ? 1 : 0,
                'dateadded' => now(),
                'datemodified' => now(),
                'addedbyfk' => 0,
                'lastuserfk' => 0,
            ]);

            return redirect()
                ->route('upload.file.index')
                ->with('success', __('message.success_file_added'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $file = File::findOrFail($id);

        // check if file exists
        if (!Storage::exists($file->alamatfile)) {
            return back()->with('error', 'File tidak ditemukan');
        }
        return response()->download(storage_path('app/' . $file->alamatfile));
    }
    public function edit($id)
    {
        $file = File::findOrFail($id);
        return view('page.upload-file.edit', [
            'type_menu' => 'setting',
            'file' => $file,
        ]);
    }
    public function update(Request $request, $id)
    {
        $file = File::findOrFail($id);
        $request->validate([
            'nm' => 'required',
            'ctn' => 'required',
            'file' => 'mimes:pdf,doc,docx',
        ]);

        try {
            $file->update([
                'nm' => $request->nm,
                'ctn' => $request->ctn,
                'aktif' => $request->aktif ? 1 : 0,
                'datemodified' => now(),
            ]);

            if ($request->hasFile('file')) {
                Storage::delete($file->alamatfile);
                $file->alamatfile = $request->file('file')->store('files');
                $file->save();
            }

            return redirect(route('upload.file.index'))->with('success', __('message.success_file_edit'));
        } catch (\Exception $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $file = File::findOrFail($id);
            Storage::disk('public')->delete($file->alamatfile);
            $file->delete();

            return back()->with('success', __('message.success_file_hapus'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
