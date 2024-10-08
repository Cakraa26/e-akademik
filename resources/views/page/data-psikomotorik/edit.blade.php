@extends('layouts.app')

@section('title', __('message.editpsikomotorik'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .load-btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader {
            pointer-events: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #fff;
            animation: an1 1.5s ease infinite;
        }

        @keyframes an1 {
            0% {
                transform: rotate(0turn);
            }

            100% {
                transform: rotate(1turn);
            }
        }
    </style>
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
                                    href="{{ route('data.stase.index') }}">{{ __('message.psikomotorik') }}</a>
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
                                <form id="form" action="{{ route('data.psikomotorik.update', $motorik->pk) }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon" class="col-sm-3">{{ __('message.nama') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control  @error('nm') is-invalid @enderror"
                                                        name="nm" id="nm" value="{{ old('nm', $motorik->nm) }}" required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="ctn" class="col-sm-3">Group</label>
                                                <div class="col-sm-9">
                                                    <div class="d-flex align-items-center">
                                                        <select
                                                            class="form-select select2 @error('groupfk') is-invalid @enderror"
                                                            id="groupfk" name="groupfk">
                                                            <option value=""></option>
                                                            @foreach ($group as $g)
                                                                <option value="{{ $g->pk }}"
                                                                    {{ old('groupfk', $motorik->groupfk) == $g->pk ? 'selected' : '' }}>
                                                                    {{ $g->nm }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-sm btn-form ml-3"
                                                            data-bs-toggle="modal" data-bs-target="#AddGroup">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    @error('groupfk')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4 row align-items-center">
                                                <label for="ctn" class="col-sm-3">{{ __('message.kategori') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="d-flex align-items-center">
                                                        <select
                                                            class="form-select select2 @error('kategorifk') is-invalid @enderror"
                                                            id="kategorifk" name="kategorifk">
                                                            <option value=""></option>
                                                            @foreach ($kategori as $k)
                                                                <option value="{{ $k->pk }}"
                                                                    {{ old('kategorifk', $motorik->kategorifk) == $k->pk ? 'selected' : '' }}>
                                                                    {{ $k->nm }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-sm btn-form ml-3"
                                                            data-bs-toggle="modal" data-bs-target="#AddKategori"><i
                                                                class="fas fa-plus"></i></button>
                                                    </div>
                                                    @error('kategorifk')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="ctn"
                                                    class="col-sm-3">{{ __('message.subkategori') }}</label>
                                                <div class="col-sm-9">
                                                    <div class="d-flex align-items-center">
                                                        <select
                                                            class="form-select select2 @error('subkategorifk') is-invalid @enderror"
                                                            id="subkategorifk" name="subkategorifk">
                                                            <option value=""></option>
                                                            @foreach ($subkategori as $s)
                                                                <option value="{{ $s->pk }}"
                                                                    {{ old('subkategorifk', $motorik->subkategorifk) == $s->pk ? 'selected' : '' }}>
                                                                    {{ $s->nm }}</option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-sm btn-form ml-3"
                                                            data-bs-toggle="modal" data-bs-target="#AddSubKategori"><i
                                                                class="fas fa-plus"></i></button>
                                                    </div>
                                                    @error('subkategorifk')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified" name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark load-btn mr-2"
                                                href="{{ route('data.psikomotorik.index') }}">
                                                <i class="fas fa-arrow-left mr-2"></i> {{ __('message.kembali') }}</a>
                                            <button type="submit" id="submit-btn" class="btn btn-primary load-btn">
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

{{-- Modal Group --}}
<div class="modal fade" id="AddGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form2" action="{{ route('data.group.store') }}"
                method="POST" data-parsley-validate>
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('message.tambahgroup') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-2">
                            <label for="nm">{{ __('message.nama') }}</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nm" name="nm" required
                                data-parsley-required-message="{{ __('message.nmrequired') }}">
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label for="ctn">{{ __('message.ctn') }}</label>
                        </div>
                        <div class="col-md-10">
                            <textarea class="form-control" name="ctn" id="ctn" cols="30" rows="10" style="height: 100px;"
                                required data-parsley-required-message="{{ __('message.ctnrequired') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n3 mb-n3">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('message.cancel') }}</button>
                    <button type="submit" class="btn btn-primary" name="redirect"
                        value="item">{{ __('message.simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Kategori --}}
<div class="modal fade" id="AddKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form3" action="{{ route('data.kategori.store') }}"
                method="POST" data-parsley-validate>
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('message.tambahkategori') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-2">
                            <label for="nm">{{ __('message.nama') }}</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nm" name="nm" required
                                data-parsley-required-message="{{ __('message.nmrequired') }}">
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label for="ctn">{{ __('message.ctn') }}</label>
                        </div>
                        <div class="col-md-10">
                            <textarea class="form-control" name="ctn" id="ctn" cols="30" rows="10" style="height: 100px;"
                                required data-parsley-required-message="{{ __('message.ctnrequired') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n3 mb-n3">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('message.cancel') }}</button>
                    <button type="submit" class="btn btn-primary" name="redirect"
                        value="item">{{ __('message.simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Sub Kategori --}}
<div class="modal fade" id="AddSubKategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form4" action="{{ route('data.subkategori.store') }}"
                method="POST" data-parsley-validate>
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('message.tambahsubkategori') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-2">
                            <label for="nm">{{ __('message.nama') }}</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nm" name="nm" required
                                data-parsley-required-message="{{ __('message.nmrequired') }}">
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label for="ctn">{{ __('message.ctn') }}</label>
                        </div>
                        <div class="col-md-10">
                            <textarea class="form-control" name="ctn" id="ctn" cols="30" rows="10" style="height: 100px;"
                                required data-parsley-required-message="{{ __('message.ctnrequired') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n3 mb-n3">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('message.cancel') }}</button>
                    <button type="submit" class="btn btn-primary" name="redirect"
                        value="item">{{ __('message.simpan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>


    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#form').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>',
            });
            $('#form2').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            });
            $('#form3').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            });
            $('#form4').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            });
        });
    </script>

    <script>
        btn = document.querySelector(".load-btn");
        const originalWidth = btn.offsetWidth;

        btn.style.width = `${originalWidth}px`;
        btn.onclick = function() {
            this.innerHTML = "<div class='loader'></div>";
        }

        document.addEventListener("DOMContentLoaded", function() {
            const btn = document.querySelector("#submit-btn");
            const originalWidth = btn.offsetWidth;

            btn.style.width = `${originalWidth}px`;

            const form = document.getElementById("form");

            form.onsubmit = function(event) {
                event.preventDefault();

                if ($(this).parsley().isValid()) {
                    btn.innerHTML = "<div class='loader'></div>";

                    this.submit();
                }
            };
        });
    </script>
@endpush
