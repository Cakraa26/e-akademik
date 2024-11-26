<?php

namespace App\Http\Controllers\API\Resident;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
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
                        'old_password' => ['The old password is incorrect']
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
}
