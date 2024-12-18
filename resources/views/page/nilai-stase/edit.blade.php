@extends('layouts.app')

@section('title', __('message.editnilaistase'))

@push('style')
    <style>
        button.btn.btn-sm {
            border-radius: 50%;
            width: 28px;
            height: 28px;
            padding: 0;
            line-height: 28px;
            text-align: center;
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
                        <span class="badge badge-success">Total Nilai Stase : {{ $kelas->nilaistase ?? '0' }}</span>
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

                <div class="card">
                    <div class="card-body">
                        @foreach ($grup as $key => $nilai)
                            @php
                                $totalSeluruh = $grup->flatMap(fn($items) => $items)->sum('nilai') / 36;

                                [$bulan, $tahun] = explode('-', $key);

                                $tanggal = date('F Y', strtotime("$tahun-$bulan"));

                                $totalNilai = $nilai->sum('nilai') / 6;
                            @endphp
                            <h2 class="section-title">{{ $tanggal }}</h2>
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
                                            <tr id="row-{{ $n->pk }}" class="text-dark">
                                                <td>{{ $n->stase->nm }}</td>
                                                <td>{{ $n->dosen->nm ?? '' }}</td>
                                                <form action="{{ route('nilai.stase.update', $n->pk) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <td>
                                                        <span class="view"
                                                            id="nilai-{{ $n->pk }}">{{ $n->nilai }}</span>
                                                        <input type="text" name="nilai" value="{{ $n->nilai }}"
                                                            class="form-control edit-field" style="display:none;">
                                                    </td>
                                                    @if ($n->nmfile)
                                                        <td class="text-nowrap">
                                                            <a href="{{ Storage::url($n->nmfile) }}">View</a>
                                                            |
                                                            <a href="{{ Storage::url($n->nmfile) }}" download>Download</a>
                                                        </td>
                                                    @else
                                                        <td class="text-danger">No File</td>
                                                    @endif
                                                    <td>
                                                        <label class="custom-switch pl-0">
                                                            <input type="checkbox" name="stsnilai[{{ $n->pk }}]"
                                                                value="2" class="custom-switch-input"
                                                                {{ $n->stsnilai == 2 ? 'checked' : '' }} disabled>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <span class="view"
                                                            id="ctnfile-{{ $n->pk }}">{{ $n->ctnfile }}</span>
                                                        <input type="text" name="ctnfile" value="{{ $n->ctnfile }}"
                                                            class="form-control edit-field" style="display:none;">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            onclick="toggleEdit({{ $n->pk }})"
                                                            id="edit-btn-{{ $n->pk }}">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary btn-sm mb-1"
                                                            id="save-btn-{{ $n->pk }}" style="display:none;">
                                                            <i class="fas fa-save"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="cancelEdit({{ $n->pk }})"
                                                            id="cancel-btn-{{ $n->pk }}" style="display:none;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                    <input type="hidden" name="totalnilai" value="{{ $totalSeluruh }}">
                                                    <input type="hidden" name="totalNilai" value="{{ $totalNilai }}">
                                                </form>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="text-right text-dark">
                                                <strong>{{ __('message.nilai') }}
                                                    :</strong></td>
                                            <td class="text-dark"><strong>{{ number_format($totalNilai, 2) }}</strong>
                                            </td>
                                            <td colspan="4"></td>
                                        </tr>
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
    <script>
        function toggleEdit(pk) {
            const row = document.getElementById('row-' + pk);
            row.querySelectorAll('.view').forEach(view => view.style.display = 'none');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'block');

            document.getElementById('edit-btn-' + pk).style.display = 'none';
            document.getElementById('save-btn-' + pk).style.display = 'inline';
            document.getElementById('cancel-btn-' + pk).style.display = 'inline';
        }

        function cancelEdit(pk) {
            const row = document.getElementById('row-' + pk);
            row.querySelectorAll('.view').forEach(view => view.style.display = 'inline');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'none');

            document.getElementById('edit-btn-' + pk).style.display = 'inline';
            document.getElementById('save-btn-' + pk).style.display = 'none';
            document.getElementById('cancel-btn-' + pk).style.display = 'none';
        }
    </script>
@endpush
