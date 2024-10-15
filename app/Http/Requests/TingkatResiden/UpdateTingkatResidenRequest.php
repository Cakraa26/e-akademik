<?php

namespace App\Http\Requests\TingkatResiden;

use App\Http\Requests\BaseRequest;

class UpdateTingkatResidenRequest extends BaseRequest
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
        $pk = $this->route("tingkatResidenId");
        return [
            'kd' => "required|unique:m_tingkat,kd," . $pk . ",pk",
            'nm' => "required",
            'warna' => "required",
            'darisemester' => "required",
            'sampaisemester' => "required",
            'aktif' => "required"
        ];
    }
}
