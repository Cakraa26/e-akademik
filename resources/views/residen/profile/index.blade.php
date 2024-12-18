@extends('layouts.app')

@section('title', 'Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        i.fa-solid.fa-minus {
            color: #c0c2c3;
            margin: 0 8px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>
            <div class="section-body">
                <div class="text-center">
                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mb-3"
                        width="10%">
                    <h2 class="section-title2">{{ $residen->nim }} {{ $residen->nm }}</h2>
                    <p class="mt-n3">Semester {{ $residen->semester }} - {{ $residen->tahunajaran->nm }}</p>
                </div>

                {{-- Alert --}}
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
                {{-- Alert End --}}

                <form id="form" action="{{ route('profile.update', $residen->pk) }}" method="POST"
                    data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <h2 class="section-title">General</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>NIM</label>
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                        name="nim" value="{{ old('nim', $residen->nim) }}">
                                    @error('nim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>{{ __('message.namalengkap') }}</label>
                                    <input type="text" class="form-control" name="nm"
                                        value="{{ old('nm', $residen->nm) }}">
                                </div>
                                <div class="form-group col-md-2 col-12 pr-0">
                                    <label>{{ __('message.nmpanggilan') }}</label>
                                    <input type="text" class="form-control" name="nickname"
                                        value="{{ old('nickname', $residen->nickname) }}">
                                </div>
                                <div class="form-group col-md-2 col-12">
                                    <label>{{ __('message.inisial') }}</label>
                                    <input type="text" class="form-control @error('inisialresiden') is-invalid @enderror"
                                        name="inisialresiden" value="{{ old('inisialresiden', $residen->inisialresiden) }}"
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
                        </div>
                    </div>

                    <h2 class="section-title">Study</h2>
                    <div class="card">
                        <div class="card-body">
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
                        </div>
                    </div>

                    <h2 class="section-title">Personal</h2>
                    <div class="card">
                        <div class="card-body">
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
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('message.cancel') }}</a>
                        <button type="submit" class="btn btn-success">Update Profile<i
                                class="fas fa-check pl-2"></i></button>

                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <!-- Page Specific JS File -->
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
