@extends('layouts.app')

@section('title', __('message.tambahstase'))

@push('style')
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
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
                transform: rotate(3turn);
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
                                    href="{{ route('data.stase.index') }}">{{ __('message.datastase') }}</a>
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
                                <form id="form" action="{{ route('data.stase.store') }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="mb-4 row align-items-center">
                                                <label for="telepon" class="col-sm-3">{{ __('message.nama') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text"
                                                        class="form-control  @error('nm') is-invalid @enderror"
                                                        name="nm" id="nm" value="{{ old('nm') }}" required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                </div>
                                            </div>
                                            <div class="mb-4 row align-items-center">
                                                <label for="ctn" class="col-sm-3">{{ __('message.ctn') }}</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="ctn" id="ctn" required
                                                        data-parsley-required-message="{{ __('message.ctnrequired') }}" style="height: 100px">{{ old('ctn') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label">Status</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="Active" name="aktif" value="1"
                                                                    {{ old('aktif') == '1' ? 'checked' : '' }} checked>
                                                                <label
                                                                    class="form-check-label">{{ __('message.active') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    id="NonActive" name="aktif" value="0"
                                                                    {{ old('aktif') == '0' ? 'checked' : '' }}>
                                                                <label
                                                                    class="form-check-label">{{ __('message.inactive') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified" name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark load-btn mr-2" href="{{ route('data.stase.index') }}">
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

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

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
