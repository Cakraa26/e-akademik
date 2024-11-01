<?php

namespace App\Http\Controllers;

use App\Models\KaryaIlmiah;
use Illuminate\Http\Request;
use App\Models\KaryaIlmiahData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KaryaIlmiahResiden extends Controller
{
    public function index()
    {
        try {
            $type_menu = 'karyailmiah';
            $residenId = auth()->user()->pk;
            $data = DB::table('m_karyailmiah')
                ->leftJoin('t_karyailmiah', function ($join) use ($residenId) {
                    $join->on('m_karyailmiah.pk', '=', 't_karyailmiah.karyailmiahfk')
                        ->where('t_karyailmiah.residenfk', '=', $residenId);
                })
                ->select(
                    'm_karyailmiah.pk as karyailmiahpk',
                    't_karyailmiah.residenfk',
                    'm_karyailmiah.nm',
                    't_karyailmiah.stssudah',
                    't_karyailmiah.ctnfile',
                    't_karyailmiah.uploadfile as file'
                )
                ->where('m_karyailmiah.aktif', 1)
                ->get();

            return view("page.karya-ilmiah-residen.index", [
                'data' => $data,
                'type_menu' => $type_menu,
            ]);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $residenId = auth()->user()->pk;
            $karyaIlmiahId = $request->karyailmiahpk;
            $data = KaryaIlmiahData::where('residenfk', $residenId)
                ->where('karyailmiahfk', $karyaIlmiahId)
                ->first();

            if ($data) {
                if (Storage::disk('public')->exists($data->uploadfile)) {
                    Storage::disk('public')->delete($data->uploadfile);
                }
            }

            $filePath = Storage::disk('public')->put('karya-ilmiah-residen', $request->file('karyaIlmiah'));

            $data = KaryaIlmiahData::updateOrCreate(
                [
                    'residenfk' => $residenId,
                    'karyailmiahfk' => $karyaIlmiahId,
                ],
                [
                    'uploadfile' => $filePath,
                    'stssudah' => 1,
                    'semester' => 1,
                    'tingkatfk' => 1,
                ]
            );
        
            return redirect()
                ->route('karya-ilmiah.residen.index')
                ->with('success', __('message.success_file_uploaded'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
