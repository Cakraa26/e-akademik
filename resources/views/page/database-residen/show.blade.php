@extends('layouts.app')

@section('title', __('message.detailresiden'))

@push('style')
    <!-- CSS Libraries -->
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

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>Semester</label>
                                        <input type="text" class="form-control" value="{{ $residen->semester }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.tingkat') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->tingkat->nm }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.karyailmiah') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->karyailmiah->nm }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.namalengkap') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->nm }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12 pr-0">
                                        <label>{{ __('message.nmpanggilan') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->nickname }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.inisial') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->inisialresiden }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.ktp') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->ktp }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="{{ $residen->email }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.hp') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->hp }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2 col-12">
                                        <label>{{ __('message.thnmasuk') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->thnmasuk }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-2 col-12">
                                        <label>{{ __('message.thnlulus') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->thnlulus }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.asalfk') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->asalfk }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.statusresiden') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->statusresiden }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.tempatlahir') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->tempatlahir }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.tgllahir') }}</label>
                                        <input type="date" class="form-control" value="{{ $residen->tgllahir }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.alamatktp') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->alamatktp }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.alamat') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->alamattinggal }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-2 col-12 pr-0">
                                        <label>{{ __('message.agama') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->agama }}" readonly>
                                    </div>
                                    <div class="form-group col-md-2 col-12">
                                        <label>{{ __('message.goldarah') }}</label>
                                        <input type="text" class="form-control" value="{{ $residen->goldarah }}"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.statuskawin') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $residen->statuskawin == 1 ? 'Menikah' : 'Belum Menikah' }}"
                                            readonly>
                                    </div>
                                </div>
                                @if ($residen->statuskawin == 1)
                                    <div class="row">
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.nmpasangan') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $residen->nmpasangan }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('message.alamatpasangan') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $residen->alamatpasangan }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3 col-9">
                                            <label>{{ __('message.hppasangan') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $residen->hppasangan }}" readonly>
                                        </div>
                                        <div class="form-group col-md-1 col-3 pl-0">
                                            <label>{{ __('message.jmlanak') }}</label>
                                            <input type="text" class="form-control"
                                                value="{{ $residen->anak }}" readonly>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.nmayah') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $residen->nmayah }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.nmibu') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $residen->nmibu }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.alamatortu') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $residen->alamatortu }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-2 col-6 pr-0">
                                        <label>{{ __('message.anakke') }}</label>
                                        <input type="number" class="form-control"
                                            value="{{ $residen->anakke }}" readonly>
                                    </div>
                                    <div class="form-group col-md-2 col-6">
                                        <label>{{ __('message.jmlsaudara') }}</label>
                                        <input type="number" class="form-control"
                                            value="{{ $residen->jmlsaudara }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.nmkontakdarurat') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $residen->nmkontak }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.hpkontakdarurat') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $residen->hpkontak }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.hubkontakdarurat') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ $residen->hubkontak }}" readonly>
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
                                        <input type="text" class="form-control" value="{{ $statuskuliah }}" readonly>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>{{ __('message.thnlulus') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('thnlulusspesialis', $residen->thnlulusspesialis) }}" readonly>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <a class="btn btn-dark" href="{{ route('database.residen.index') }}">
                                        <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                                </div>
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
