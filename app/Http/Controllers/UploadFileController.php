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
            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;
            $inputData['alamatfile'] = Storage::disk('public')->put('upload-file', $request->file('uploadFile'));
            $inputData['dateadded'] = now();
            $inputData['addedbyfk'] = auth()->user()->pk;
            $inputData['lastuserfk'] = auth()->user()->pk;

            File::create($inputData);

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

        if (!Storage::exists($file->alamatfile)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        return response()->download(public_path('storage/' . $file->alamatfile));
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
        try {
            $file = File::findOrFail($id);

            $inputData = $request->all();
            $inputData['aktif'] = $request->has('aktif') ? 1 : 0;
            if ($request->hasFile('uploadFile')) {
                $inputData['alamatfile'] = Storage::disk('public')->put('upload-file', $request->file('uploadFile'));

                if (Storage::disk('public')->exists($file->alamatfile)) {
                    Storage::disk('public')->delete($file->alamatfile);
                }
            }

            $file->update($inputData);

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
    public function indexResiden()
    {
        return view('residen.download-file-residen.index', [
            'type_menu' => 'download',
            'file' => File::all(),
        ]);
    }
}
