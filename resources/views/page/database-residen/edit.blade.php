@extends('layouts.app')

@section('title', __('message.editresiden'))

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
                            <div class="breadcrumb-item">{{ __('message.edit') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

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
                                <form id="form" action="{{ route('database.residen.update', $residen->pk) }}"
                                    method="POST" data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>Semester</label>
                                            <input type="text" class="form-control"
                                                value="{{ $residen->semester }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.tingkat') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $residen->tingkat->nm }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.karyailmiah') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $residen->karyailmiah->nm }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.namalengkap') }}</label>
                                            <input type="text" class="form-control" name="nm"
                                                value="{{ old('nm', $residen->nm) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12 pr-0">
                                            <label>{{ __('message.nmpanggilan') }}</label>
                                            <input type="text" class="form-control" name="nickname"
                                                value="{{ old('nickname', $residen->nickname) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.inisial') }}</label>
                                            <input type="text"
                                                class="form-control @error('inisialresiden') is-invalid @enderror"
                                                name="inisialresiden"
                                                value="{{ old('inisialresiden', $residen->inisialresiden) }}"
                                                maxlength="3">
                                            @error('inisialresiden')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.ktp') }}</label>
                                            <input type="text" class="form-control @error('ktp') is-invalid @enderror"
                                                name="ktp" value="{{ old('ktp', $residen->ktp) }}">
                                            @error('ktp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ old('email', $residen->email) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.hp') }}</label>
                                            <input type="text" class="form-control @error('hp') is-invalid @enderror"
                                                name="hp" value="{{ old('hp', $residen->hp) }}">
                                            @error('hp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2 col-12">
                                            <label>{{ __('message.thnmasuk') }}</label>
                                            <input type="text" class="form-control" name="thnmasuk"
                                                value="{{ old('thnmasuk', $residen->thnmasuk) }}">
                                        </div>
                                        <div class="form-group col-md-2 col-12">
                                            <label>{{ __('message.thnlulus') }}</label>
                                            <input type="text" class="form-control" name="thnlulus"
                                                value="{{ old('thnlulus', $residen->thnlulus) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.asalfk') }}</label>
                                            <input type="text" class="form-control" name="asalfk"
                                                value="{{ old('asalfk', $residen->asalfk) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.statusresiden') }}</label>
                                            <select class="form-control select2" name="statusresiden" id="statusresiden">
                                                <option value="Mandiri"
                                                    {{ old('statusresiden', $residen->statusresiden) == 'Mandiri' ? 'selected' : '' }}>
                                                    Mandiri
                                                </option>
                                                <option value="PNS"
                                                    {{ old('statusresiden', $residen->statusresiden) == 'PNS' ? 'selected' : '' }}>
                                                    PNS</option>
                                                <option value="Patubel"
                                                    {{ old('statusresiden', $residen->statusresiden) == 'Patubel' ? 'selected' : '' }}>
                                                    Patubel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.tempatlahir') }}</label>
                                            <input type="text" class="form-control" name="tempatlahir"
                                                value="{{ old('tempatlahir', $residen->tempatlahir) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.tgllahir') }}</label>
                                            <input type="date" class="form-control" name="tgllahir"
                                                value="{{ old('tgllahir', $residen->tgllahir) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.alamatktp') }}</label>
                                            <input type="text" class="form-control" name="alamatktp"
                                                value="{{ old('alamatktp', $residen->alamatktp) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.alamat') }}</label>
                                            <input type="text" class="form-control" name="alamattinggal"
                                                value="{{ old('alamattinggal', $residen->alamattinggal) }}">
                                        </div>
                                        <div class="form-group col-md-2 col-12 pr-0">
                                            <label>{{ __('message.agama') }}</label>
                                            <input type="text" class="form-control" name="agama"
                                                value="{{ old('agama', $residen->agama) }}">
                                        </div>
                                        <div class="form-group col-md-2 col-12">
                                            <label>{{ __('message.goldarah') }}</label>
                                            <input type="text" class="form-control" name="goldarah"
                                                value="{{ old('goldarah', $residen->goldarah) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.statuskawin') }}</label>
                                            <select class="form-control select2" name="statuskawin" id="statuskawin">
                                                <option value="0"
                                                    {{ old('statuskawin', $residen->statuskawin) == 0 ? 'selected' : '' }}>
                                                    Belum Menikah
                                                </option>
                                                <option value="1"
                                                    {{ old('statuskawin', $residen->statuskawin) == 1 ? 'selected' : '' }}>
                                                    Menikah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="pasangan">
                                        <div class="row">
                                            <div class="form-group col-md-4 col-12">
                                                <label>{{ __('message.nmpasangan') }}</label>
                                                <input type="text" class="form-control" name="nmpasangan"
                                                    value="{{ old('nmpasangan', $residen->nmpasangan) }}" required
                                                    data-parsley-required-message="{{ __('message.nmpasanganrequired') }}">
                                            </div>
                                            <div class="form-group col-md-4 col-12">
                                                <label>{{ __('message.alamatpasangan') }}</label>
                                                <input type="text" class="form-control" name="alamatpasangan"
                                                    value="{{ old('alamatpasangan', $residen->alamatpasangan) }}" required
                                                    data-parsley-required-message="{{ __('message.alamatpasanganrequired') }}">
                                            </div>
                                            <div class="form-group col-md-3 col-9">
                                                <label>{{ __('message.hppasangan') }}</label>
                                                <input type="text" class="form-control" name="hppasangan"
                                                    value="{{ old('hppasangan', $residen->hppasangan) }}" required
                                                    data-parsley-required-message="{{ __('message.hppasarangrequired') }}">
                                            </div>
                                            <div class="form-group col-md-1 col-3 pl-0">
                                                <label>{{ __('message.jmlanak') }}</label>
                                                <input type="text" class="form-control" name="anak"
                                                    value="{{ old('anak', $residen->anak) }}" data-parsley-type="number"
                                                    data-parsley-type-message="{{ __('message.jmlanaknumeric') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.nmayah') }}</label>
                                            <input type="text" class="form-control" name="nmayah"
                                                value="{{ old('nmayah', $residen->nmayah) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.nmibu') }}</label>
                                            <input type="text" class="form-control" name="nmibu"
                                                value="{{ old('nmibu', $residen->nmibu) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.alamatortu') }}</label>
                                            <input type="text" class="form-control" name="alamatortu"
                                                value="{{ old('alamatortu', $residen->alamatortu) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2 col-6 pr-0">
                                            <label>{{ __('message.anakke') }}</label>
                                            <input type="number" class="form-control" name="anakke"
                                                value="{{ old('anakke', $residen->anakke) }}">
                                        </div>
                                        <div class="form-group col-md-2 col-6">
                                            <label>{{ __('message.jmlsaudara') }}</label>
                                            <input type="number" class="form-control" name="jmlsaudara"
                                                value="{{ old('jmlsaudara', $residen->jmlsaudara) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.nmkontakdarurat') }}</label>
                                            <input type="text" class="form-control" name="nmkontak"
                                                value="{{ old('nmkontak', $residen->nmkontak) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.hpkontakdarurat') }}</label>
                                            <input type="text" class="form-control" name="hpkontak"
                                                value="{{ old('hpkontak', $residen->hpkontak) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.hubkontakdarurat') }}</label>
                                            <input type="text" class="form-control" name="hubkontak"
                                                value="{{ old('hubkontak', $residen->hubkontak) }}">
                                        </div>
                                        <div class="form-group col-md-4 col-12">
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
                                                        $statuskuliah = 'Daftar';
                                                        break;
                                                }
                                            @endphp
                                            <label>{{ __('message.statuskuliah') }}</label>
                                            <input type="text" class="form-control" value="{{ $statuskuliah }}"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.thnlulus') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ old('thnlulusspesialis', $residen->thnlulusspesialis) }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <a class="btn btn-dark mr-1" href="{{ route('database.residen.index') }}">
                                            <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('message.simpan') }} <i class="fas fa-save pl-1"></i>
                                        </button>
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

    <script>
        $(document).ready(function() {
            var $pasangan = $('#pasangan input');
            var $statuskawin = $('#statuskawin');

            function updatePasangan() {
                var status = $statuskawin.val();

                if (status == "0") {
                    $('#pasangan').hide();
                    $pasangan.prop('required', false);
                    $pasangan.attr('data-parsley-required', 'false');
                    $pasangan.parsley().reset();
                } else {
                    $('#pasangan').show();
                    $pasangan.prop('required', true);
                    $pasangan.attr('data-parsley-required', 'true');
                }
            }

            $statuskawin.on('select2:select', updatePasangan);
            updatePasangan();
        });
    </script>

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
