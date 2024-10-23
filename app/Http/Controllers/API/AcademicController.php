<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\ResidenUploadKaryaIlmiahRequest;
use App\Models\KaryaIlmiahData;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Storage;

class AcademicController extends Controller
{
    public function getKaryaIlimiahByResiden($residenId)
    {
        try {
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
                ->get();

            return response()->json(["data" => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function residenUploadKaryaIlmiah(ResidenUploadKaryaIlmiahRequest $request, $karyaIlmiahId, $residenId)
    {
        DB::beginTransaction();

        try {
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

            DB::commit();

            return response()->json(['data' => $data], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Data not found'], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
