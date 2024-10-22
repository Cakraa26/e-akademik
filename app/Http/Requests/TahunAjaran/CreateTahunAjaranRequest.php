<?php

namespace App\Http\Requests\TahunAjaran;

use App\Http\Requests\BaseRequest;

class CreateTahunAjaranRequest extends BaseRequest
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
            'nm' => 'required|unique:m_thnajaran,nm',
            'ctn' => 'required',
            'aktif' => 'required'
        ];
    }
}
