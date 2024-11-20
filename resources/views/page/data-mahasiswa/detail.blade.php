@extends('layouts.app')
@section('title', __('message.detailresiden'))

@push('style')
    <!-- CSS Libraries -->
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
                                    href="{{ route('data.mahasiswa.index') }}">{{ __('message.residen') }}</a></div>
                            <div class="breadcrumb-item">{{ __('message.detail') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.nama') }}</label>
                        <h2 class="section-title2">{{ $residen->nm }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.nmpanggilan') }}</label>
                        <h2 class="section-title2">{{ $residen->nickname }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.inisial') }}</label>
                        <h2 class="section-title2">{{ $residen->inisialresiden }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.agama') }}</label>
                        <h2 class="section-title2">{{ $residen->agama }}</h2>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.ktp') }}</label>
                        <h2 class="section-title2">{{ $residen->ktp }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <h2 class="section-title2">{{ $residen->email }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.hp') }}</label>
                        <h2 class="section-title2">{{ $residen->hp }}</h2>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.dateofbirth') }}</label>
                        <h2 class="section-title2">{{ $residen->tempatlahir }},
                            {{ date('d-m-Y', strtotime($residen->tgllahir)) }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.alamatktp') }}</label>
                        <h2 class="section-title2">{{ $residen->alamatktp }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.alamat') }}</label>
                        <h2 class="section-title2">{{ $residen->alamattinggal }}</h2>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.asalfk') }}</label>
                        <h2 class="section-title2">{{ $residen->asalfk }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.stsresiden') }}</label>
                        <h2 class="section-title2">{{ $residen->statusresiden }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.thnmasuk') }}</label>
                        <h2 class="section-title2">{{ $residen->thnmasuk }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.thnlulus') }}</label>
                        <h2 class="section-title2">{{ $residen->thnlulus }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.goldarah') }}</label>
                        <h2 class="section-title2">{{ $residen->goldarah }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.stskawin') }}</label>
                        <h2 class="section-title2">
                            {{ $residen->statuskawin === 1 ? __('message.menikah') : __('message.belummenikah') }}</h2>
                    </div>
                </div>

                @if ($residen->statuskawin === 1)
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('message.nmpasangan') }}</label>
                            <h2 class="section-title2">{{ $residen->nmpasangan }}</h2>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('message.alamatpasangan') }}</label>
                            <h2 class="section-title2">{{ $residen->alamatpasangan }}</h2>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('message.hppasangan') }}</label>
                            <h2 class="section-title2">{{ $residen->hppasangan }}</h2>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('message.jmlanak') }}</label>
                            <h2 class="section-title2">{{ $residen->anak }}</h2>
                        </div>
                    </div>
                @endif

                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.nmayah') }}</label>
                        <h2 class="section-title2">{{ $residen->nmayah }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.nmibu') }}</label>
                        <h2 class="section-title2">{{ $residen->nmibu }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.alamatortu') }}</label>
                        <h2 class="section-title2">{{ $residen->alamatortu }}</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.anakke') }}</label>
                        <h2 class="section-title2">{{ $residen->anakke }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.jmlsaudara') }}</label>
                        <h2 class="section-title2">{{ $residen->jmlsaudara }}</h2>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('message.nmkontakdarurat') }}</label>
                        <h2 class="section-title2">{{ $residen->nmkontak }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.hpkontakdarurat') }}</label>
                        <h2 class="section-title2">{{ $residen->hpkontak }}</h2>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('message.hubkontakdarurat') }}</label>
                        <h2 class="section-title2">{{ $residen->hubkontak }}</h2>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
