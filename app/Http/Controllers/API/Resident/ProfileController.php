<?php

namespace App\Http\Controllers\API\Resident;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Http\Requests\Profile\UpdateProfileResidentRequest;
use App\Http\Requests\Profile\RegisterFace;
use App\Http\Requests\Profile\RegisterNotifToken;
use App\Models\Residen;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = Residen::findOrFail(auth()->user()->pk);

            if (!\Hash::check($request->old_password, $data->password)) {
                return response()->json([
                    'errors' => [
                        'old_password' => app()->getLocale() === 'id' ? ['Kata sandi lama salah.'] : ['Old password is wrong.'],
                    ],
                ], 400);
            }

            $data->password = bcrypt($request->password);
            $data->save();

            DB::commit();
            return response()->json([
                'data' => $data,
            ], 200);
        } catch (ModelNotFoundException) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getBiodata()
    {
        try {
            $user = Residen::findOrFail(auth()->user()->pk);

            return response()->json(['data' => $user], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateBiodata(UpdateProfileResidentRequest $request)
    {
        try {
            $user = Residen::findOrFail(auth()->user()->pk);

            $payload = $request->all();
            $payload['lastuserfk'] = auth()->user()->pk;
            $payload['datemodied'] = date('Y-m-d H:i:s');

            $user->update($payload);

            return response()->json(['data' => $user], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function registerFace(RegisterFace $reqeust)
    {
        try {
            $user = Residen::findOrFail(auth()->user()->pk);
            $user->face_dt = $reqeust->face_dt;
            $user->save();

            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function registerNotifToken(RegisterNotifToken $reqeust)
    {
        try {
            $user = Residen::findOrFail(auth()->user()->pk);
            $user->notif_token = $reqeust->notif_token;
            $user->save();

            return response()->json(['data' => $user], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data not found',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
