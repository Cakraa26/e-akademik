<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
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
            'nim' => 'nullable|unique:m_residen,nim',
            'nm' => 'required',
            'nickname' => 'required',
            'inisialresiden' => 'required|unique:m_residen,inisialresiden',
            'ktp' => 'required|unique:m_residen,ktp',
            'email' => 'required|unique:m_residen,email',
            'hp' => 'required|unique:m_residen,hp',
            'password' => 'required|min:8',
            'tempatlahir' => 'required',
            'tgllahir' => 'required',
            'alamatktp' => 'required',
            'alamattinggal' => 'required',
            'agama' => 'required',
            'goldarah' => 'required',
            'thnmasuk' => 'required',
            'thnlulus' => 'required',
            'asalfk' => 'required',
            'statusresiden' => 'required',
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
            'datemodified' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nim.unique' => 'NIM sudah terdaftar.',
            'ktp.unique' => 'No. KTP sudah terdaftar.',
            'email.unique' => 'Alamat Email sudah terdaftar.',
            'hp.unique' => 'No. Telepon sudah terdaftar.',
            'inisialresiden.unique' => 'Inisial Residen sudah terdaftar.',
            'nm.required' => 'Nama Lengkap wajib diisi.',
            'nickname.required' => 'Nama Panggilan wajib diisi.',
            'inisialresiden.required' => 'Inisial Residen wajib diisi.',
            'ktp.required' => 'No. KTP wajib diisi.',
            'email.required' => 'Alamat Email wajib diisi.',
            'hp.required' => 'No. Telepon wajib diisi.',
            'password.min' => 'Kata Sandi setidaknya terdiri dari 8 karakter.',
            'tempatlahir.required' => 'Tempat Lahir wajib diisi.',
            'tgllahir.required' => 'Tanggal Lahir wajib diisi.',
            'alamatktp.required' => 'Alamat KTP wajib diisi.',
            'alamattinggal.required' => 'Alamat Tinggal wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'goldarah.required' => 'Gol Darah wajib diisi.',
            'thnmasuk.required' => 'Tahun Masuk wajib diisi.',
            'thnlulus.required' => 'Tahun Lulus wajib diisi.',
            'asalfk.required' => 'Asal FK wajib diisi.',
            'statusresiden.required' => 'Status Residen wajib diisi.',
            'statuskawin.required' => 'Status Kawin wajib diisi.',
            'nmpasangan.required' => 'Nama Suami / Istri wajib diisi.',
            'alamatpasangan.required' => 'Alamat Suami / Istri wajib diisi.',
            'hppasangan.required' => 'No. Telepon Suami / Istri wajib diisi.',
            'anak.required' => 'Jumlah Anak wajib diisi.',
            'nmayah.required' => 'Nama Ayah wajib diisi.',
            'nmibu.required' => 'Nama Ibu wajib diisi.',
            'alamatortu.required' => 'Alamat Orang Tua wajib diisi.',
            'anakke.required' => 'Anak ke- wajib diisi.',
            'jmlsaudara.required' => 'Anak wajib diisi.',
            'nmkontak.required' => 'Nama Kontak Darurat wajib diisi.',
            'hpkontak.required' => 'No. Telepon Kontak Darurat wajib diisi.',
            'hubkontak.required' => 'Hubungan Kontak Darurat wajib diisi.'
        ];
    }
}
