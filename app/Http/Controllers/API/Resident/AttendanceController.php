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
        $setting = DB::table('s_setting')->select('terlambat', 'jmlharikerja', 'max_alpa')->first();
        $attendance = Absen::where('residenfk', auth()->user()->pk)->whereDate('check_in', now())->first();
        $totalAlpa = Absen::where('residenfk', auth()->user()->pk)->whereMonth('check_in', now())->where('alpa', 1)->count();

        return response()->json([
            'is_active_day' => $date->stsaktif,
            'setting' => $setting,
            'attendance' => $attendance,
            'schedule' => $date,
            'can_attendance' => $totalAlpa < $setting->max_alpa
        ], 200);
    }

    public function checkIn(CheckInRequest $request)
    {
        $checkIn = now();
        $setting = DB::table('s_setting')->select('terlambat', 'jmlharikerja', 'max_alpa')->first();
        $totalAlpa = Absen::where('residenfk', auth()->user()->pk)->whereMonth('check_in', now())->where('alpa', 1)->count();

        // cek hari ini apakah aktif absen
        $date = HariKerja::where('code', date('w'))->firstOrFail();
        if ($date->stsaktif == 0) {
            return response()->json([
                'message' => 'Hari ini tidak absen'
            ], 400);
        }

        if ($totalAlpa < $setting->max_alpa) {
            return response()->json([
                'message' => 'Anda sudah mencapai batas maksimal alpa'
            ], 400);
        }

        // hitung total waktu terlambat
        $totalWakturTerlambat = $checkIn->diffInMinutes($date->jammasuk);

        // simpan absen
        DB::beginTransaction();
        try {
            $data = Absen::create([
                'residenfk' => auth()->user()->pk,
                'tingkatfk' => auth()->user()->tingkatfk,
                'semesterfk' => auth()->user()->semesterfk,
                'check_in' => $checkIn,
                'loc_in' => $request->loc_in,
                'photo_in' => Storage::disk('public')->put('attendance-check-in', $request->file('photo_in')),
                'terlambat' => $totalWakturTerlambat,
                'hadir' => 1
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
            $setting = DB::table('s_setting')->first();
            $data = [];
            $kehadiran = 0;
            $alpa = 0;
            $terlambat = 0;

            if ($request->has('start_date') && $request->has('end_date')) {
                $query = Absen::where('residenfk', auth()->user()->pk);
                $data = $query->whereBetween('check_in', [$request->start_date, $request->end_date])
                    ->get();

                $alpa = clone $query;
                $alpa = $alpa->where('alpa', 1)->count();

                $kehadiran = clone $query;
                $kehadiran = $kehadiran->where('hadir', 1)->count();

                $terlambat = $data->sum('terlambat');
            }


            return response()->json([
                'data' => $data,
                'kehadiran' => $kehadiran,
                'terlambat' => $terlambat,
                'alpa' => $alpa,
                'setting' => $setting
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
