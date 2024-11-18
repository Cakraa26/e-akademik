<?php

namespace App\Http\Requests\Attendance;

use App\Http\Requests\BaseRequest;

class CheckOutRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'loc_out' => 'required',
            'photo_out' => 'required|image|mimes:png,jpeg',
        ];
    }
}
