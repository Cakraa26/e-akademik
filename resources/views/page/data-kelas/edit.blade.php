@extends('layouts.app')

@section('title', __('message.editkelas'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/load-btn.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $kelas->residen->nm }}</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('data.kelas.index') }}">{{ __('message.datakelas') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.edit') }}</div>
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
                                <form id="form" action="{{ route('data.kelas.update', $kelas->pk) }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.thnajaran') }}</label>
                                                <div class="col-sm-9">
                                                    <select
                                                        class="form-select select2 @error('thnajaranfk') is-invalid @enderror"
                                                        id="thnajaranfk" name="thnajaranfk">
                                                        <option value=""></option>
                                                        @foreach ($thnajaran as $t)
                                                            <option value="{{ $t->pk }}"
                                                                {{ old('thnajaranfk', $kelas->thnajaranfk) == $t->pk ? 'selected' : '' }}>
                                                                {{ $t->nm }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">Semester</label>
                                                <div class="col-sm-9">
                                                    <select
                                                        class="form-select select2 @error('semester') is-invalid @enderror"
                                                        id="semester" name="semester">
                                                        <option value=""></option>
                                                        @foreach ($semester as $s)
                                                            <option value="{{ $s->pk }}"
                                                                {{ old('semester', $kelas->semester) == $s->pk ? 'selected' : '' }}>
                                                                {{ $s->semester }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.tingkat') }}</label>
                                                <div class="col-sm-9">
                                                    <select
                                                        class="form-select select2 @error('tingkatfk') is-invalid @enderror"
                                                        id="tingkatfk" name="tingkatfk">
                                                        <option value=""></option>
                                                        @foreach ($tingkat as $t)
                                                            <option value="{{ $t->pk }}"
                                                                {{ old('tingkatfk', $kelas->tingkatfk) == $t->pk ? 'selected' : '' }}>
                                                                {{ $t->kd }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label class="col-sm-3">{{ __('message.ctn') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="ctn_tingkat" id="ctn_tingkat" required
                                                        data-parsley-required-message="{{ __('message.ctnrequired') }}" style="height: 100px">{{ old('ctn_tingkat', $kelas->ctn_tingkat) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">Status</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="status" name="aktif" value="1" 
                                                            {{ old('aktif', $kelas->aktif) == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="status">{{ __('message.active') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark load-btn mr-2" href="{{ route('data.kelas.index') }}">
                                                <i class="fas fa-arrow-left pr-2"></i> {{ __('message.kembali') }}</a>
                                            <button type="submit" class="btn btn-primary load-btn">
                                                {{ __('message.simpan') }} <i class="fas fa-save pl-2"></i>
                                            </button>
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
    <script src="{{ asset('js/page/load-btn.js') }}"></script>

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
