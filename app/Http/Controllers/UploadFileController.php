<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Ramsey\Uuid\v1;

class UploadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page.upload-file.index', [
            'type_menu' => 'setting',
            'files' => File::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.upload-file.create', [
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
            'nm' => 'required',
            'ctn' => 'required',
            'file' => 'required|mimes:pdf,doc,docx',
        ]);

        try {
            File::create([
                'nm' => $request->nm,
                'alamatfile' => $request->file('file')->store('files'),
                'ctn' => $request->ctn,
                'aktif' => $request->aktif ? 1 : 0,
                'dateadded' => now(),
                'datemodified' => now(),
                'addedbyfk' => 0,
                'lastuserfk' => 0,
            ]);

            return redirect(route('upload.file.index'))->with('success', __('message.success_file_added'));
        } catch (\Exception $th) {
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
        $file = File::findOrFail($id);

        // check if file exists
        if (!Storage::exists($file->alamatfile)) {
            return back()->with('error', 'File tidak ditemukan');
        }
        return response()->download(storage_path('app/' . $file->alamatfile));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = File::findOrFail($id);
        return view('page.upload-file.edit', [
            'type_menu' => 'setting',
            'file' => $file,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);

        try {
            Storage::delete($file->alamatfile);
            $file->delete();

            return back()->with('success', __('message.success_file_hapus'));
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
