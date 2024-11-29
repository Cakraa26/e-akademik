<?php

namespace App\Http\Controllers\API\Resident;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\ResidenUpdateUploadPsikomotorikRequest;
use App\Http\Requests\Academic\ResidenUploadKaryaIlmiahRequest;
use App\Http\Requests\Academic\ResidenUploadPsikomotorikRequest;
use App\Http\Requests\Academic\ResidenUploadStaseRequest;
use App\Models\JadwalTransactionNilai;
use App\Models\KaryaIlmiahData;
use App\Models\MotorikTransaction;
use App\Models\MotorikTransactionData;
use App\Models\SubKategoriMotorik;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Log;
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
                ->where('m_karyailmiah.aktif', 1)
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

    public function getPsikomotorikByResiden(Request $request)
    {
        try {
            $data = DB::table('m_motorik')
                ->leftJoin('t_motorik', function ($join) {
                    $join->on('m_motorik.pk', '=', 't_motorik.motorikfk')
                        ->where('t_motorik.residenfk', auth()->user()->pk);
                })
                ->join('m_subkategori_motorik', 'm_motorik.subkategorifk', '=', 'm_subkategori_motorik.pk')
                ->where('m_motorik.kategorifk', $request->motorikKategori)
                ->whereIn('m_motorik.subkategorifk', $request->motorikSubKategori ? [$request->motorikSubKategori] : SubKategoriMotorik::where('aktif', 1)->get()->pluck('pk')->toArray())
                ->where('m_motorik.aktif', 1)
                ->where('m_motorik.nm', 'LIKE', '%' . $request->search . '%')
                ->select(
                    'm_motorik.pk as motorik_pk',
                    'm_motorik.nm as motorik_name',
                    'm_subkategori_motorik.pk as subkategori_pk',
                    'm_subkategori_motorik.nm as subkategori_name',
                    't_motorik.pk as motorik_transaction_pk',
                    't_motorik.qtymandiri as mandiri',
                    't_motorik.qtybimbingan as bimbingan',
                    DB::raw("CASE WHEN t_motorik.stsmandiri = 1 OR t_motorik.stsbimbingan = 1 THEN 1 ELSE 0 END as is_waiting")
                )
                ->orderBy("motorik_pk")
                ->get();

            $grouped = $data->groupBy('subkategori_name')->map(function ($items, $subkategori) {
                return [
                    'subkategori' => $subkategori,
                    'data' => $items,
                ];
            })->values();

            return response()->json(['data' => $grouped], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function uploadPsikomotorikByResiden(ResidenUploadPsikomotorikRequest $request, $motorikId)
    {
        // mandiri => 0
        // bimbingan => 1

        DB::beginTransaction();

        try {
            $motorikTransaction = MotorikTransaction::where('motorikfk', $motorikId)->where('residenfk', auth()->user()->pk)->first();

            if (!$motorikTransaction) {
                $motorikTransaction = MotorikTransaction::create([
                    'motorikfk' => $motorikId,
                    'residenfk' => auth()->user()->pk,
                    'qtymandiri' => $request->status == 0 ? 1 : 0,
                    'qtybimbingan' => $request->status == 1 ? 1 : 0,
                    'stsmandiri' => $request->status == 0 ? 1 : 0,
                    'stsbimbingan' => $request->status == 1 ? 1 : 0,
                ]);
            } else {
                $motorikTransaction->qtymandiri = $request->status == 0 ? $motorikTransaction->qtymandiri + 1 : $motorikTransaction->qtymandiri;
                $motorikTransaction->qtybimbingan = $request->status == 1 ? $motorikTransaction->qtybimbingan + 1 : $motorikTransaction->qtybimbingan;
                if ($request->status == 0) {
                    $motorikTransaction->stsmandiri = 1;
                } else if ($request->status == 1) {
                    $motorikTransaction->stsbimbingan = 1;
                }
                $motorikTransaction->save();
            }

            $file = Storage::disk('public')->put('motorik-residen', $request->file('fileMotorik'));

            $motorikTransaction->motorikData()->create([
                'residenfk' => auth()->user()->pk,
                'motorikfk' => $motorikId,
                'tgl' => now()->format('Y-m-d H:i:s'),
                'nmfile' => $file,
                'stsmandiri' => $request->status == 0 ? 1 : 0,
                'stsbimbingan' => $request->status == 1 ? 1 : 0,
                'stsapproved' => 1,
                'semester' => auth()->user()->semesterfk,
                'tingkatfk' => auth()->user()->tingkatfk,
            ]);

            DB::commit();

            return response()->json(['data' => $motorikTransaction], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function getPsikomotorikDetailByResiden($motorikTransactionId)
    {
        try {
            $data = DB::table('t_motorik_dt')
                ->join('t_motorik', 't_motorik_dt.t_motorik_fk', '=', 't_motorik.pk')
                ->join('m_motorik', 'm_motorik.pk', '=', 't_motorik.motorikfk')
                ->join('m_subkategori_motorik', 'm_motorik.subkategorifk', '=', 'm_subkategori_motorik.pk')
                ->join('m_tingkat', 't_motorik_dt.tingkatfk', '=', 'm_tingkat.pk')
                ->select(
                    't_motorik_dt.pk',
                    't_motorik.pk as motorikpk',
                    't_motorik_dt.tgl',
                    'm_tingkat.nm as tingkat',
                    't_motorik_dt.semester',
                    DB::raw("CASE 
                    WHEN t_motorik_dt.stsbimbingan = 1 THEN 'Bimbingan' 
                    WHEN t_motorik_dt.stsmandiri = 1 THEN 'Mandiri' 
                    ELSE '' 
                END as type"),
                    //     DB::raw("CASE 
                    //     WHEN t_motorik_dt.stsapproved = 1 THEN 'Waiting' 
                    //     WHEN t_motorik_dt.stsapproved = 2 THEN 'Approved' 
                    //     WHEN t_motorik_dt.stsapproved = 3 THEN 'Cancel' 
                    //     ELSE '' 
                    // END as status"),
                    't_motorik_dt.stsapproved as status',
                    DB::raw("CASE 
                    WHEN t_motorik_dt.stsapproved != 2 THEN 1 
                    ELSE 0 
                END as can_delete"),
                    DB::raw("CASE 
                    WHEN t_motorik_dt.stsapproved != 2 THEN 1 
                    ELSE 0 
                END as can_upload"),
                    't_motorik_dt.ctn'
                )
                ->where('t_motorik.pk', $motorikTransactionId)
                ->get();

            return response()->json(
                [
                    'motorik' => MotorikTransaction::with(['motorik.subCategory'])->findOrFail($motorikTransactionId),
                    'data' => $data
                ]
                ,
                200
            );
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }

    public function updateUploadPsikomotorikByResiden(ResidenUpdateUploadPsikomotorikRequest $request, $motorikId, $motorikTransactionDataId)
    {
        // mandiri => 0
        // bimbingan => 1

        DB::beginTransaction();

        try {
            $motorikTransaction = MotorikTransaction::with(['motorikData'])->where('motorikfk', $motorikId)->where('residenfk', auth()->user()->pk)->firstOrFail();
            $motorikTransactionData = $motorikTransaction->motorikData()->findOrFail($motorikTransactionDataId);

            if ($motorikTransactionData->stsapproved == 2) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            if (Storage::disk('public')->exists($motorikTransactionData->nmfile)) {
                Storage::disk('public')->delete($motorikTransactionData->nmfile);
            }

            $motorikTransactionData->update([
                'nmfile' => Storage::disk('public')->put('motorik-residen', $request->file('fileMotorik')),
                'stsapproved' => 1
            ]);

            if ($motorikTransactionData->stsmandiri == 1) {
                $motorikTransaction->stsmandiri = 1;
            } else if ($motorikTransactionData->stsbimbingan == 1) {
                $motorikTransaction->stsbimbingan = 1;
            }
            $motorikTransaction->save();

            DB::commit();

            return response()->json(['data' => $motorikTransaction], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Data not found'], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteUploadPsikomotorikByResiden($motorikId, $motorikTransactionDataId)
    {
        DB::beginTransaction();

        try {
            // $motorikTransaction = MotorikTransaction::with(['motorikData'])->where('motorikfk', $motorikId)->where('residenfk', auth()->user()->pk)->firstOrFail();
            $motorikTransaction = MotorikTransaction::with(['motorikData'])->findOrFail($motorikId);
            $motorikTransactionData = $motorikTransaction->motorikData()->findOrFail($motorikTransactionDataId);

            if ($motorikTransactionData->stsapproved == 2) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            if (Storage::disk('public')->exists($motorikTransactionData->nmfile)) {
                Storage::disk('public')->delete($motorikTransactionData->nmfile);
            }

            if ($motorikTransactionData->stsmandiri == 1) {
                $motorikTransaction->stsmandiri = $motorikTransaction->motorikData()->where('stsmandiri', 1)->count() - 1 > 0 ? 1 : 0;
                $motorikTransaction->qtymandiri -= 1;
            } else if ($motorikTransactionData->stsbimbingan == 1) {
                $motorikTransaction->stsbimbingan = $motorikTransaction->motorikData()->where('stsbimbingan', 1)->count() - 1 > 0 ? 1 : 0;
                $motorikTransaction->qtybimbingan -= 1;
            }

            $motorikTransaction->save();
            $motorikTransactionData->delete();

            DB::commit();

            return response()->json(['data' => $motorikTransaction], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => $e], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getNilaiStaseResiden(Request $request)
    {
        $monthNow = now()->format('m');

        try {
            $data = DB::table('t_jadwal_nilai')
                ->join('t_jadwal', 't_jadwal_nilai.jadwalfk', '=', 't_jadwal.pk')
                ->join('m_dosen', 't_jadwal_nilai.dosenfk', '=', 'm_dosen.pk')
                ->join('m_stase', 't_jadwal_nilai.stasefk', '=', 'm_stase.pk')
                ->join('m_thnajaran', 't_jadwal.thnajaranfk', '=', 'm_thnajaran.pk')
                ->select(
                    't_jadwal_nilai.pk',
                    't_jadwal.bulan',
                    't_jadwal.tahun',
                    DB::raw('CONCAT(t_jadwal.tahun, "-", t_jadwal.bulan, "-", "01") as date'),
                    'm_stase.nm as stase',
                    'm_dosen.nm as dosen',
                    DB::raw("CASE WHEN t_jadwal_nilai.nilai > 0 THEN 1 ELSE 0 END as has_nilai"),
                    't_jadwal_nilai.stsnilai as status',
                    DB::raw("CASE WHEN t_jadwal_nilai.stsnilai != 3 AND t_jadwal_nilai.nilai = 0 THEN 1 ELSE 0 END as can_upload"),
                    DB::raw("CASE WHEN t_jadwal.bulan < $monthNow AND (t_jadwal_nilai.nmfile IS NOT NULL OR t_jadwal_nilai.stsnilai != 2) THEN 1 ELSE 0 END as highlight_row_red")
                )
                ->where('t_jadwal.residenfk', auth()->user()->pk)
                ->where('m_thnajaran.pk', $request->tahunAjaran ? $request->tahunAjaran : auth()->user()->thnajaranfk)
                ->orderBy('t_jadwal.bulan')
                ->get();

            // map query result 
            $grouped = $data->groupBy('date')->map(function ($items, $date) {
                return [
                    'date' => $date,
                    'data' => $items,
                ];
            })->values();

            return response()->json(['data' => $grouped], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Failed to retrieve data', 'error' => $e->getMessage()], 500);
        }
    }

    public function uploadStaseResiden(ResidenUploadStaseRequest $request, $staseJadwalNilaiId)
    {
        DB::beginTransaction();

        try {
            $staseNilai = JadwalTransactionNilai::findOrFail($staseJadwalNilaiId);

            if ($staseNilai->stsnilai == 3) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            if ($staseNilai->nmfile && Storage::disk('public')->exists($staseNilai->nmfile)) {
                Storage::disk('public')->delete($staseNilai->nmfile);
            }

            $filePath = Storage::disk('public')->put('stase-residen', $request->file('fileStase'));

            $staseNilai->nmfile = $filePath;
            $staseNilai->stsnilai = 1;
            $staseNilai->save();

            DB::commit();

            return response()->json(['data' => $staseNilai], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Data not found'], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getNilaiUTSResiden(Request $request)
    {
        try {
            $data = DB::table('m_kelas')
                ->join('m_thnajaran', 'm_kelas.thnajaranfk', '=', 'm_thnajaran.pk')
                ->select(
                    'm_thnajaran.nm as thnajaran',
                    'status_uts',
                )
                ->where('m_kelas.thnajaranfk', $request->thnajaran ? $request->thnajaran : auth()->user()->thnajaranfk)
                ->where('m_kelas.residenfk', auth()->user()->pk)
                ->first();

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function getNilaiUASResiden(Request $request)
    {
        try {
            $data = DB::table('m_kelas')
                ->join('m_thnajaran', 'm_kelas.thnajaranfk', '=', 'm_thnajaran.pk')
                ->select(
                    'm_thnajaran.nm as thnajaran',
                    'status_uas',
                )
                ->where('m_kelas.thnajaranfk', $request->thnajaran ? $request->thnajaran : auth()->user()->thnajaranfk)
                ->where('m_kelas.residenfk', auth()->user()->pk)
                ->first();

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
