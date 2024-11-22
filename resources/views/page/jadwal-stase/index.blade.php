@extends('layouts.app')

@section('title', __('message.jdwstase'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
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
                            <div class="breadcrumb-item">{{ __('message.jdwstase') }}</div>
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
                                    <select class="form-control select2" name="thnajaranfk" id="thnajaranfk">
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
                                        <a href="{{ route('jadwal.stase.index') }}" class="btn btn-secondary">
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

                @if ($residen->isNotEmpty())
                    @foreach ($residen as $semester => $dataResiden)
                        @if (request('semester') == null || request('semester') == $semester)
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="section-title">Semester : {{ $semester }}</h2>
                                    <div class="table-responsive">
                                        <table class="myTable table-striped table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('message.aksi') }}</th>
                                                    <th class="text-center">
                                                        No
                                                    </th>
                                                    <th>{{ __('message.inisial') }}</th>
                                                    <th>{{ __('message.nmresiden') }}</th>
                                                    @foreach ($bulan as $b)
                                                        <th>{{ date('F', strtotime($b)) }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @foreach ($dataResiden as $r)
                                                    <tr>
                                                        <td>
                                                            <div>
                                                                <a href="{{ route('jadwal.stase.edit', $r->pk) }}"
                                                                    class="btn btn-info {{ Request::is('jadwal-stase/' . $r->pk . '/edit') ? 'active' : '' }}"><i
                                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                            </div>
                                                        </td>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $r->inisialresiden }}</td>
                                                        <td class="text-nowrap">{{ $r->nm }}</td>
                                                        @foreach ($bulan as $b)
                                                            @php
                                                                $b = date('m', strtotime($b));

                                                                $jadwal = $r->jadwal->firstWhere('bulan', $b);
                                                            @endphp
                                                            <td>{{ $jadwal && $jadwal->stase ? $jadwal->stase->nm : '' }}
                                                            </td>
                                                        @endforeach
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
@endpush
