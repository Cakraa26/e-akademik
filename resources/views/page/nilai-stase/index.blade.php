@extends('layouts.app')

@section('title', __('message.nilaistase'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            border-bottom: 1px solid #666;
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
                            <div class="breadcrumb-item">{{ __('message.nilaistase') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3 pr-0">
                                    <label for="thnajaranfk" class="form-label">{{ __('message.thnajaran') }}</label>
                                    <select class="form-control select2" name="thnajaranfk" id="thnajaranfk"
                                        onchange="updateInput(this.value)">
                                        @foreach ($thnajaran as $t)
                                            <option value="{{ $t->pk }}"
                                                {{ Request::get('thnajaranfk') == $t->pk || (!Request::get('thnajaranfk') && $t->aktif == 1) ? 'selected' : '' }}>
                                                {{ $t->nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 pr-0">
                                    <label for="tingkatfk" class="form-label">{{ __('message.tingkat') }}</label>
                                    <select class="form-control select2" name="tingkatfk" id="tingkatfk">
                                        <option value=""></option>
                                        @foreach ($tingkat as $t)
                                            <option value="{{ $t->pk }}"
                                                {{ Request::get('tingkatfk') == $t->pk ? 'selected' : '' }}>
                                                {{ $t->kd }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 mb-3 pr-0">
                                    <label for="semester" class="form-label">{{ __('message.semester') }}</label>
                                    <select class="form-control select2" name="semester" id="semester">
                                        <option value=""></option>
                                        @foreach ($semester as $s)
                                            <option value="{{ $s->pk }}"
                                                {{ Request::get('semester') == $s->pk ? 'selected' : '' }}>
                                                {{ $s->semester }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8 col-md-3 mb-3 pr-0">
                                    <label>&nbsp;</label>
                                    <input type="text" name="nm" class="form-control" value="{{ request('nm') }}">
                                </div>
                                <div class="col-3 col-md-2">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-danger mr-1"><i
                                                class="fas fa-search"></i></button>
                                        <a href="{{ route('nilai.stase.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible show fade" role="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                {{-- Alert End --}}

                @if ($jadwal->isNotEmpty())
                    @foreach ($jadwal as $semester => $jadwals)
                        @if (request('semester') == null || request('semester') == $semester)
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="section-title">Semester : {{ $semester }}</h2>
                                    <div class="table-responsive">
                                        <table class="myTable table-striped table nowrap" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        No
                                                    </th>
                                                    <th>{{ __('message.nmresiden') }}</th>
                                                    @foreach ($bulan as $b)
                                                        <th>{{ date('F', strtotime($b)) }}</th>
                                                    @endforeach
                                                    <th>Total</th>
                                                    <th>{{ __('message.aksi') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @foreach ($jadwals->groupBy('residenfk') as $residenfk => $j)
                                                    <tr
                                                        @if ($j->first()->residen->tingkatfk == 1 || $j->first()->residen->tingkatfk == 2) style="background-color: #E98580;" 
                                                        @elseif($j->first()->residen->tingkatfk == 3) style="background-color: #F4D06F;" 
                                                        @elseif($j->first()->residen->tingkatfk == 4 || $j->first()->residen->tingkatfk == 5) style="background-color: #A4C686;" @endif>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $j->first()->residen->nm }}</td>
                                                        @php $total = 0; @endphp
                                                        @foreach ($bulan as $b)
                                                            @php
                                                                $bulanNumber = date('m', strtotime($b));

                                                                $nilai =
                                                                    $j->where('bulan', $bulanNumber)->first()
                                                                        ?->jadwalNilai?->nilai ?? 0;

                                                                $total += $nilai / 6;
                                                            @endphp
                                                            <td>{{ $nilai ?? '0' }}</td>
                                                        @endforeach
                                                        <td>{{ number_format($total, 2) }}</td>
                                                        <td>
                                                            @if ($j->isNotEmpty() && $j->first()->jadwalNilai)
                                                                <a href="{{ route('nilai.stase.edit', $j->first()->jadwalNilai->pk) }}"
                                                                    class="btn btn-info {{ Request::is('nilai-stase/' . $j->first()->jadwalNilai->pk . '/edit') ? 'active' : '' }}">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <h5 class="text-center pt-3">{{ __('message.nodata') }}</h5>
                @endif

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.boostrap4.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('.myTable').DataTable({
                scrollX: true,
                searching: false
            });
        });
    </script>

    <script>
        function updateInput(value) {
            const selectThnajaran = document.getElementById('select_thnajaran');
            if (selectThnajaran) {
                selectThnajaran.value = value;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let selectElement = document.getElementById('thnajaranfk');
            if (selectElement) {
                let initialValue = selectElement.value;
                updateInput(initialValue);
            }
        });
    </script>
@endpush
