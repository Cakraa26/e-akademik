@extends('layouts.app')

@section('title', __('message.approved'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        i.fa-solid.fa-angle-right {
            color: #c0c2c3;
            margin: 0 8px;
        }

        .btn-download,
        .btn-download:hover {
            background: #fff;
            border: 1px solid #1a5319;
            color: #1a5319;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('message.approved') }}</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('monitoring.index') }}">{{ __('message.mngmotorikpendek') }}</a>
                            </div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('monitoring.detail', $tmotorik->pk) }}">{{ __('message.detail') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.confirmapprov') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.nmprosedur') }}</label>
                        <h2 class="section-title2">{{ $tmotorik->motorik->nm }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">{{ __('message.tingkat') }}</label>
                        <h2 class="section-title2">{{ $tmotorik->residen->tingkat->kd }}</h2>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.residen') }}</label>
                        <h2 class="section-title2">{{ $tmotorik->residen->nm }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">Semester</label>
                        <h2 class="section-title2">{{ $tmotorik->residen->semester }}</h2>
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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible show fade" role="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('monitoring.update', $tmotorik_dt->pk) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @foreach ($tmotorik->motorikData as $detail)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4 row align-items-center">
                                            <label class="col-sm-4">{{ __('message.tglupload') }}</label>
                                            <div class="col-sm-8">
                                                <input type="datetime" class="form-control" name="tgl" id="tgl"
                                                    value="{{ old('tgl', $detail->tgl) }}" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-4 row align-items-center">
                                            <label class="col-sm-4">File</label>
                                            <div class="col-sm-8">
                                                <a href="{{ Storage::url($detail->nmfile) }}" download
                                                    class="btn btn-outline-success btn-sm">Download <i
                                                        class="fas fa-download pl-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3 align-items-center">
                                            <label for="stsapproved" class="col-sm-3">Status</label>
                                            <div class="col-sm-9">
                                                <label class="mr-3">
                                                    <input type="radio" name="stsapproved[{{ $detail->pk }}]"
                                                        value="2" class="custom-switch-input"
                                                        {{ $detail->stsapproved == 2 ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Approved</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="stsapproved[{{ $detail->pk }}]"
                                                        value="3" class="custom-switch-input"
                                                        {{ $detail->stsapproved == 3 ? 'checked' : '' }}>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Cancel</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <label for="ctn" class="col-sm-3">{{ __('message.ctn') }}</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="ctn[{{ $detail->pk }}]" id="ctn" style="height: 100px">{{ old('ctn', $detail->ctn) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a class="btn btn-dark mr-1" href="{{ route('monitoring.detail', $tmotorik->residen->pk) }}">
                                <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('message.simpan') }} <i class="fas fa-save pl-1"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
