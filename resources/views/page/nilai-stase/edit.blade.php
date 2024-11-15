@extends('layouts.app')

@section('title', __('message.editnilaistase'))

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
                                    href="{{ route('nilai.stase.index') }}">{{ __('message.nilaistase') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.edit') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.nama') }}</label>
                        <h2 class="section-title2">{{ $jadwal->residen->nm }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">Semester</label>
                        <h2 class="section-title2">{{ $jadwal->residen->semester }}</h2>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.tingkat') }}</label>
                        <h2 class="section-title2">{{ $jadwal->residen->tingkat->kd }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <span class="badge badge-success">Total Nilai Stase : {{ $kelas->nilaistase }}</span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        @php
                            $tanggal = date('F Y', strtotime("$tahun-$bulan"));
                        @endphp
                        <h2 class="section-title">{{ $tanggal }}</h2>
                        @foreach ($grup as $nilai)
                            <div class="table-responsive mb-3">
                                <table class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th>Stase</th>
                                            <th>{{ __('message.dosen') }}</th>
                                            <th>{{ __('message.nilai') }}</th>
                                            <th>File {{ __('message.upload') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.ctn') }}</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nilai as $n)
                                            <tr>
                                                <td>{{ $n->stase->nm }}</td>
                                                <td>{{ $n->dosen->nm }}</td>
                                                <td>{{ $n->nilai }}</td>
                                                <td class="text-nowrap">View | Download</td>
                                                <td>
                                                    <label class="custom-switch pl-0">
                                                        <input type="checkbox" name="stsnilai[{{ $n->pk }}]"
                                                            value="2" class="custom-switch-input"
                                                            {{ $n->stsnilai == 2 ? 'checked' : '' }}>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td>
                                                <td>{{ $n->ctnfile }}</td>
                                                <td>
                                                    <button class="btn btn-warning">Edit</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
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
