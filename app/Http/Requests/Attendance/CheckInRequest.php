<?php

namespace App\Http\Requests\Attendance;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends BaseRequest
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
            'loc_in' => 'required',
            'photo_in' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ];
    }
}
