<?php

namespace App\Http\Controllers\API\Resident;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\CheckInRequest;
use App\Http\Requests\Attendance\CheckOutRequest;
use App\Models\Absen;
use App\Models\HariKerja;
use DB;
use Illuminate\Http\Request;
use Log;
use Storage;

class AttendanceController extends Controller
{
    public function getAttendanceState()
    {
        $date = HariKerja::where('code', date('w'))->firstOrFail();
        $setting = DB::table('s_setting')->select('terlambat', 'jmlharikerja')->first();
        $attendance = Absen::where('residenfk', auth()->user()->pk)->whereDate('check_in', now())->first();

        return response()->json([
            'is_active_day' => $date->stsaktif,
            'setting' => $setting,
            'attendance' => $attendance,
            'schedule' => $date
        ], 200);
    }

    public function checkIn(CheckInRequest $request)
    {
        // cek hari ini apakah aktif absen
        $date = HariKerja::where('code', date('w'))->firstOrFail();
        if ($date->stsaktif == 0) {
            return response()->json([
                'message' => 'Hari ini tidak absen'
            ], 400);
        }

        // cek apakah belum saatnya absen
        if ($date->jammasuk > date('H:i:s')) {
            return response()->json([
                'message' => 'Belum saatnya absen'
            ], 400);
        }

        Log::info($request->file('photo_in'));

        // cek apakah dia sudah melewati jumlah batas terlambat

        // simpan absen
        DB::beginTransaction();
        try {
            $data = Absen::create([
                'residenfk' => auth()->user()->pk,
                'tingkatfk' => auth()->user()->tingkatfk,
                'semesterfk' => auth()->user()->semesterfk,
                'check_in' => now(),
                'loc_in' => $request->loc_in,
                'photo_in' => Storage::disk('public')->put('attendance-check-in', $request->file('photo_in'))
            ]);

            DB::commit();
            return response()->json($data, 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function checkOut(CheckOutRequest $request)
    {
        // cek hari ini apakah aktif absen
        // $date = HariKerja::where('code', date('w'))->firstOrFail();
        // if ($date->stsaktif == 0) {
        //     return response()->json([
        //         'message' => 'Hari ini tidak absen'
        //     ], 400);
        // }

        // // cek apakah belum saatnya absen
        // if ($date->jamkeluar > date('H:i:s')) {
        //     return response()->json([
        //         'message' => 'Belum saatnya absen'
        //     ], 400);
        // }

        // cek apakah dia sudah absen masuk
        $attendance = Absen::where('residenfk', auth()->user()->pk)->whereDate('check_in', now())->first();
        if (!$attendance) {
            return response()->json([
                'message' => 'Anda belum absen masuk'
            ], 400);
        }

        // simpan absen
        DB::beginTransaction();
        try {
            $attendance->check_out = now();
            $attendance->loc_out = $request->loc_out;
            $attendance->photo_out = Storage::disk('public')->put('attendance-check-out', $request->file('photo_out'));
            $attendance->save();

            DB::commit();
            return response()->json($attendance, 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getAfektif(Request $request)
    {
        try {
            $data = Absen::where('residenfk', auth()->user()->pk);

            if ($request->has('start_date') && $request->has('end_date')) {
                $data->whereBetween('check_in', [$request->start_date, $request->end_date]);
            }

            $data = $data->get();

            return response()->json(['data' => $data], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
