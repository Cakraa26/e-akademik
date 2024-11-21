@extends('layouts.app')

@section('title', __('message.tambahpengumuman'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
      <link rel="stylesheet"
      href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
  <link rel="stylesheet"
      href="{{ asset('library/codemirror/lib/codemirror.css') }}">
  <link rel="stylesheet"
      href="{{ asset('library/codemirror/theme/duotone-dark.css') }}">
  <link rel="stylesheet"
      href="{{ asset('library/selectric/public/selectric.css') }}">
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
                                    href="{{ route('pengumuman.index') }}">{{ __('message.pengumuman') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.tambah') }}</div>
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
                                <form id="form" action="{{ route('pengumuman.update', $pengumuman->pk) }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="tglbuat" class="col-sm-3">{{ __('message.tglbuat') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="date"
                                                        class="form-control  @error('nm') is-invalid @enderror"
                                                        name="tglbuat" id="nm" value="{{ old('tglbuat', $pengumuman->tglbuat) }}" required
                                                        data-parsley-required-message="{{ __('message.tglbuatrequired') }}">
                                                    @error('nm')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="tglberlaku"
                                                    class="col-sm-3">{{ __('message.tglberlakusampai') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="date"
                                                        class="form-control  @error('tglberlaku') is-invalid @enderror"
                                                        name="tglberlaku" id="tglberlaku" value="{{ old('tglberlaku', $pengumuman->tglsampai) }}"
                                                        required
                                                        data-parsley-required-message="{{ __('message.tglberlakurequired') }}">
                                                    @error('tglberlaku')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-4 row align-items-center">
                                                <label for="judul" class="col-sm-3">{{ __('message.judul') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control  @error('nm') is-invalid @enderror"
                                                        name="judul" id="judul" value="{{ old('judul', $pengumuman->judul) }}" required
                                                        data-parsley-required-message="{{ __('message.judulrequired') }}">
                                                    @error('judul')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-4 row align-items-center">
                                                <label for="pengumuman"
                                                    class="col-sm-3">{{ __('message.pengumuman') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea class="summernote" name="pengumuman" id="pengumuman" required
                                                        data-parsley-required-message="{{ __('message.ctnrequired') }}" style="height: 100px">{!! old('pengumuman', $pengumuman->catatan) !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <div class="col-sm-9">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="aktif"
                                                    id="inlineCheckbox1" 
                                                    value="1" {{$pengumuman->aktif ? 'checked' : ''}}>
                                                <label class="form-check-label"
                                                    for="inlineCheckbox1">Aktif</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified" name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark mr-2" href="{{ route('pengumuman.index') }}">
                                                <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('message.simpan') }} <i class="fas fa-save pl-1"></i>
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
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('library/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

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
