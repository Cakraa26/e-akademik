<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileResidentRequest extends BaseRequest
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
            // 'nim' => 'required|unique:m_residen,nim',
            'nm' => 'required',
            'nickname' => 'required',
            'inisialresiden' => 'required|unique:m_residen,inisialresiden',
            'ktp' => 'required|unique:m_residen,ktp',
            // 'email' => 'required|unique:m_residen,email',
            'hp' => 'required|unique:m_residen,hp',
            // 'password' => 'required|min:8',
            'tempatlahir' => 'required',
            'tgllahir' => 'required',
            'alamatktp' => 'required',
            'alamattinggal' => 'required',
            'agama' => 'required',
            'goldarah' => 'required',
            'thnmasuk' => 'required',
            'thnlulus' => 'required',
            'asalfk' => 'required',
            // 'statusresiden' => 'required',
            'statuskawin' => 'required',
            'nmpasangan' => 'required_if:statuskawin,=,1',
            'alamatpasangan' => 'required_if:statuskawin,=,1',
            'hppasangan' => 'required_if:statuskawin,=,1',
            'anak' => 'required_if:statuskawin,=,1',
            'nmayah' => 'required',
            'nmibu' => 'required',
            'alamatortu' => 'required',
            'anakke' => 'required',
            'jmlsaudara' => 'required',
            'nmkontak' => 'required',
            'hpkontak' => 'required',
            'hubkontak' => 'required',
            // 'datemodified' => 'required',
        ];
    }
}
