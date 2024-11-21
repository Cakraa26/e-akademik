@extends('layouts.app')

@section('title', __('message.detailresiden'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('database.residen.index') }}">{{ __('message.databaseresiden') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.viewdetail') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                    <strong>{{ __('message.success') }}!</strong> {{ session('success') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="form" data-parsley-validate>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="semester" class="col-sm-3">{{ __('message.semester') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="semester"
                                                        value="{{ $residen->semester }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="tingkat" class="col-sm-3">{{ __('message.tingkat') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="tingkat"
                                                        value="{{ $residen->tingkat->nm }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="karyailmiah"
                                                    class="col-sm-3">{{ __('message.karyailmiah') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="karyailmiah"
                                                        value="{{ $residen->karyailmiah->nm }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="nama"
                                                    class="col-sm-3">{{ __('message.namalengkap') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nm" id="nm"
                                                        value="{{ old('nm', $residen->nm) }}" disabled
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                    @error('nm')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="namapanggilan"
                                                    class="col-sm-3">{{ __('message.namapanggilan') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nickname"
                                                        id="namapanggilan"
                                                        value="{{ old('nickname', $residen->nickname) }}" disabled
                                                        data-parsley-required-message="{{ __('message.nicknamerequired') }}">
                                                    @error('nickname')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="inisial" class="col-sm-3">{{ __('message.inisial') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="inisial" id="inisial"
                                                        value="{{ old('inisial', $residen->inisialresiden) }}" disabled
                                                        data-parsley-required-message="{{ __('message.nicknamerequired') }}">
                                                    @error('inisial')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="noktp" class="col-sm-3">{{ __('message.noktp') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="noktp"
                                                        id="noktp" value="{{ old('noktp', $residen->ktp) }}" disabled
                                                        data-parsley-required-message="{{ __('message.ktprequired') }}">
                                                    @error('noktp')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="email" class="col-sm-3">{{ __('message.email') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="email"
                                                        id="email" value="{{ old('email', $residen->email) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.emailrequired') }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="hp" class="col-sm-3">{{ __('message.tlp') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="hp"
                                                        id="hp" value="{{ old('hp', $residen->hp) }}" disabled
                                                        data-parsley-required-message="{{ __('message.tlprequired') }}">
                                                    @error('hp')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="hp" class="col-sm-3">{{ __('message.tlp') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="hp"
                                                        id="hp" value="{{ old('hp', $residen->hp) }}" disabled
                                                        data-parsley-required-message="{{ __('message.tlprequired') }}">
                                                    @error('hp')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="tempatlahir"
                                                    class="col-sm-3">{{ __('message.tempatlahir') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="tempatlahir"
                                                        id="tempatlahir"
                                                        value="{{ old('tempatlahir', $residen->tempatlahir) }}" disabled
                                                        data-parsley-required-message="{{ __('message.tempatlahirrequired') }}">
                                                    @error('tempatlahir')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="tgllahir"
                                                    class="col-sm-3">{{ __('message.tgllahir') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" name="tgllahir"
                                                        id="tgllahir" value="{{ old('tgllahir', $residen->tgllahir) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.tgllahirrequired') }}">
                                                    @error('hp')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="alamatktp"
                                                    class="col-sm-3">{{ __('message.alamatktp') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="alamatktp"
                                                        id="alamatktp"
                                                        value="{{ old('alamatktp', $residen->alamatktp) }}" disabled
                                                        data-parsley-required-message="{{ __('message.alamatktprequired') }}">
                                                    @error('alamatktp')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="agama" class="col-sm-3">{{ __('message.agama') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="agama"
                                                        id="agama" value="{{ old('agama', $residen->agama) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.agamarequired') }}">
                                                    @error('agama')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="goldarah"
                                                    class="col-sm-3">{{ __('message.goldarah') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="goldarah"
                                                        id="goldarah" value="{{ old('goldarah', $residen->goldarah) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.goldarahrequired') }}">
                                                    @error('goldarah')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="thnmasuk"
                                                    class="col-sm-3">{{ __('message.thnmasuk') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="thnmasuk"
                                                        id="thnmasuk" value="{{ old('thnmasuk', $residen->thnmasuk) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.thnmasukrequired') }}">
                                                    @error('thnmasuk')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="thnlulusan"
                                                    class="col-sm-3">{{ __('message.tahunlulusan') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="thnlulusan"
                                                        id="thnlulusan"
                                                        value="{{ old('thnlulusan', $residen->thnlulus) }}" disabled
                                                        data-parsley-required-message="{{ __('message.thnllulusanrequired') }}">
                                                    @error('thnlulusan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="asalfk"
                                                    class="col-sm-3">{{ __('message.asalfakultas') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="asalfk"
                                                        id="asalfk" value="{{ old('asalfk', $residen->asalfk) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.asalfakultasrequired') }}">
                                                    @error('asalfk')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="statusresiden"
                                                    class="col-sm-3">{{ __('message.statusresiden') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select select2" id="statusresiden"
                                                        name="statusresiden" disabled>
                                                        <option value=""></option>
                                                        <option value="Mandiri"
                                                            {{ old('statusresiden', $residen->statusresiden) == 'Mandiri' ? 'selected' : '' }}>
                                                            Mandiri</option>
                                                        <option value="PNS"
                                                            {{ old('statusresiden', $residen->statusresiden) == 'PNS' ? 'selected' : '' }}>
                                                            PNS</option>
                                                        <option value="Petubel"
                                                            {{ old('statusresiden', $residen->statusresiden) == 'Petubel' ? 'selected' : '' }}>
                                                            Petubel</option>
                                                    </select>
                                                    @error('statusresiden')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="statuskawin"
                                                    class="col-sm-3">{{ __('message.statuskawin') }}</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select select2" id="statuskawin"
                                                        name="statuskawin" disabled>
                                                        <option value=""></option>
                                                        <option value="1"
                                                            {{ old('statuskawin', $residen->statuskawin) == 1 ? 'selected' : '' }}>
                                                            Menikah</option>
                                                        <option value="0"
                                                            {{ old('statuskawin', $residen->statuskawin) == 0 ? 'selected' : '' }}>
                                                            Belum Menikah</option>
                                                    </select>
                                                    @error('statusresiden')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="nmpasangan"
                                                    class="col-sm-3">{{ __('message.nmpasangan') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nmpasangan"
                                                        id="nmpasangan"
                                                        value="{{ old('nmpasangan', $residen->nmpasangan) }}" disabled
                                                        data-parsley-required-message="{{ __('message.nmpasanganrequired') }}">
                                                    @error('nmpasangan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="alamatpasangan"
                                                    class="col-sm-3">{{ __('message.alamatpasangan') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="alamatpasangan"
                                                        id="alamatpasangan"
                                                        value="{{ old('alamatpasangan', $residen->alamatpasangan) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.alamatpasanganrequired') }}">
                                                    @error('alamatpasangan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="hppasangan"
                                                    class="col-sm-3">{{ __('message.hppasangan') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="hppasangan"
                                                        id="hppasangan"
                                                        value="{{ old('hppasangan', $residen->hppasangan) }}" disabled
                                                        data-parsley-required-message="{{ __('message.hppasarangrequired') }}">
                                                    @error('hppasangan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="jmlanak"
                                                    class="col-sm-3">{{ __('message.jmlanak') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="jmlanak"
                                                        id="jmlanak" value="{{ old('jmlanak', $residen->anak) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.jmlanaknumeric') }}">
                                                    @error('jmlanak')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="nmayah"
                                                    class="col-sm-3">{{ __('message.nmayah') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nmayah"
                                                        id="nmayah" value="{{ old('nmayah', $residen->nmayah) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.nmayahrequired') }}">
                                                    @error('nmayah')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="alamatortu"
                                                    class="col-sm-3">{{ __('message.alamatortu') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="alamatortu"
                                                        id="alamatortu"
                                                        value="{{ old('alamatortu', $residen->alamatortu) }}" disabled
                                                        data-parsley-required-message="{{ __('message.alamatorturequired') }}">
                                                    @error('alamatortu')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="anakke"
                                                    class="col-sm-3">{{ __('message.anakke') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="anakke"
                                                        id="anakke" value="{{ old('anakke', $residen->anakke) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.anakkerequired') }}">
                                                    @error('anakke')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="jmlsaudara"
                                                    class="col-sm-3">{{ __('message.jmlsaudara') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="jmlsaudara"
                                                        id="jmlsaudara"
                                                        value="{{ old('jmlsaudara', $residen->jmlsaudara) }}" disabled
                                                        data-parsley-required-message="{{ __('message.jmlsaudararequired') }}">
                                                    @error('jmlsaudara')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="nmkontakdarurat"
                                                    class="col-sm-3">{{ __('message.nmkontakdarurat') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nmkontakdarurat"
                                                        id="nmkontakdarurat"
                                                        value="{{ old('nmkontakdarurat', $residen->nmkontak) }}" disabled
                                                        data-parsley-required-message="{{ __('message.nmkontakdaruratrequired') }}">
                                                    @error('nmkontakdarurat')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="nmrkontakdarurat"
                                                    class="col-sm-3">{{ __('message.nmrkontakdarurat') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nmrkontakdarurat"
                                                        id="nmrkontakdarurat"
                                                        value="{{ old('nmrkontakdarurat', $residen->hpkontak) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.nmrkontakdaruratrequired') }}">
                                                    @error('nmrkontakdarurat')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="hubkontakdarurat"
                                                    class="col-sm-3">{{ __('message.hubkontakdarurat') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="hubkontakdarurat"
                                                        id="hubkontakdarurat"
                                                        value="{{ old('hubkontakdarurat', $residen->hubkontak) }}"
                                                        disabled
                                                        data-parsley-required-message="{{ __('message.hubkontakdaruratrequired') }}">
                                                    @error('hubkontakdarurat')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @php
                                                switch ($residen->statuskuliah) {
                                                    case '1':
                                                        $statuskuliah = 'Mahasiswa';
                                                        break;
                                                    case '3':
                                                        $statuskuliah = 'Alumni';
                                                        break;
                                                    case '4':
                                                        $statuskuliah = 'Cuti';
                                                        break;
                                                    default:
                                                        $statuskuliah = 'Tidak Valid';
                                                        break;
                                                }
                                            @endphp
                                            <div class="mb-4 row align-items-center">
                                                <label for="statuskuliah"
                                                    class="col-sm-3">{{ __('message.statuskuliah') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="statuskuliah"
                                                        id="statuskuliah" value="{{ $statuskuliah }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="tahunlulas" class="col-sm-3">Tahun Lulas</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" "
                                                            id="tahunlulas"
                                                            value="{{ $residen->thnlulusspesialis ? $residen->thnlulusspesialis : '-' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="datetime-local" class="form-control" id="datemodified"
                                            name="datemodified"
                                            value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                        <div class="row mt-2">
                                            <div class="col-12 d-flex justify-content-start">
                                                <a class="btn btn-dark mr-2" href="{{ route('database.residen.index') }}">
                                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
        <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

        <!-- Page Specific JS File -->
        <script>
            $(document).ready(function() {
                $('#form').parsley({
                    errorClass: 'is-invalid parsley-error',
                    successClass: 'is-valid',
                    errorsWrapper: '<span class="invalid-feedback"></span>',
                    errorTemplate: '<div></div>'
                })
            });
        </script>
@endpush
