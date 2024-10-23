@extends('layouts.app')

@section('title', __('message.datakelas'))

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
                            <div class="breadcrumb-item">{{ __('message.datakelas') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                    <strong>{{ __('message.success') }}!</strong> {{ session('success') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            {{-- Alert End --}}

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
                                                {{ $t->aktif == 1 || Request::get('thnajaranfk') == $t->pk ? 'selected' : '' }}>
                                                {{ $t->nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 pr-0">
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
                                    <label for="tingkatfk" class="form-label">{{ __('message.tingkat') }}</label>
                                    <select class="form-control select2" name="tingkatfk" id="tingkatfk">
                                        <option value=""></option>
                                        @foreach ($tingkat as $t)
                                            <option value="{{ $t->pk }}"
                                                {{ Request::get('tingkatfk') == $t->pk ? 'selected' : '' }}>
                                                {{ $t->nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 col-md-3 mb-3">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-danger mr-1"><i
                                                class="fas fa-search"></i></button>
                                        <a href="{{ route('data.kelas.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if (!$aktif)
                    <div class="d-flex justify-content-end mb-4">
                        <a class="btn btn-success {{ Request::is('data-kelas/create') ? 'active' : '' }}"
                            href="{{ route('data.kelas.create') }}" data-toggle="tooltip"
                            title="{{ __('message.tambah') }}"><i
                                class="fas fa-plus pr-2"></i>{{ __('message.tambah') }}</a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 2</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 2)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ViewDetail{{ $k->pk }}"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 4</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 4)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary swal-6"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 6</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 6)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ViewDetail{{ $k->pk }}"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 8</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 8)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ViewDetail{{ $k->pk }}"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 1</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 1)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ViewDetail{{ $k->pk }}"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 3</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 3)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ViewDetail{{ $k->pk }}"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 5</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 5)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ViewDetail{{ $k->pk }}"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Semester : 7</h2>
                            <div class="table-responsive">
                                <table class="myTable table-striped table nowrap" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.inisial') }}</th>
                                            <th>{{ __('message.nmresiden') }}</th>
                                            <th>{{ __('message.hp') }}</th>
                                            <th>{{ __('message.tingkat') }}</th>
                                            <th>{{ __('message.karyailmiah') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($kelas as $k)
                                            @if ($k->semester === 7)
                                                <tr>
                                                    <th>{{ $no++ }}</th>
                                                    <td>{{ $k->residen->inisialresiden }}</td>
                                                    <td>{{ $k->residen->nm }}</td>
                                                    <td>{{ $k->residen->hp }}</td>
                                                    <td>{{ $k->tingkat->kd }}</td>
                                                    <td>{{ $k->residen->karyailmiah->nm }}</td>
                                                    <td>{{ $k->aktif === 1 ? __('message.active') : __('message.cuti') }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <a href="{{ route('data.kelas.edit', $k->pk) }}"
                                                                class="btn btn-info {{ Request::is('data-kelas/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ViewDetail{{ $k->pk }}"><i
                                                                    class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </section>

        {{-- Modal Detail --}}
        @foreach ($kelas as $k)
            <div class="modal fade" id="ViewDetail{{ $k->pk }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h6 class="text-center mb-3">DATA NILAI RESIDEN</h6>
                            <div class="row">
                                <div class="col-md-5 mb-1">
                                    <span>{{ __('message.nama') }} : {{ $k->residen->nm }}</span>
                                </div>
                                <div class="col-md-7 text-md-right mb-1">
                                    <span>{{ __('message.thnajaran') }}/{{ __('message.semester') }} :
                                        {{ $k->thnajaran->nm }}/{{ $k->semester }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <span>{{ __('message.tingkat') }} : {{ $k->tingkat->kd }}</span>
                                </div>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table border="1" class="table-striped table">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="text-center">MCQ</th>
                                            <th colspan="7" class="text-center">OSCE</th>
                                            <th rowspan="2">HASIL UAS</th>
                                            <th colspan="4" class="text-center">TOTAL (UAS + UTS + STASE)</th>
                                            <th rowspan="2">HASIL</th>
                                            <th rowspan="2">KETERANGAN (SEMESTER)</th>
                                            <th rowspan="2">Keterangan Karya Ilmiah</th>
                                            <th rowspan="2">KETERANGAN TINGKAT</th>
                                        </tr>
                                        <tr>
                                            <th>BENAR MCQ</th>
                                            <th>MCQ</th>
                                            <th>PED</th>
                                            <th>TRAUMA</th>
                                            <th>SPINE</th>
                                            <th>LOWER</th>
                                            <th>TUMOR</th>
                                            <th>HAND</th>
                                            <th>HASIL OSCE</th>
                                            <th>UAS (20%)</th>
                                            <th>UTS (20%)</th>
                                            <th>STASE (60%)</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $k->mcqbenar_uts }}</td>
                                            <td>{{ $k->mcq_uts }}</td>
                                            <td>{{ $k->osce_ped_uts }}</td>
                                            <td>{{ $k->osce_trauma_uts }}</td>
                                            <td>{{ $k->osce_spine_uts }}</td>
                                            <td>{{ $k->osce_lower_uts }}</td>
                                            <td>{{ $k->osce_tumor_uts }}</td>
                                            <td>{{ $k->osce_hand_uts }}</td>
                                            <td>{{ $k->hasil_osce_uts }}</td>
                                            <td>{{ $k->uas }}</td>
                                            <td>{{ $k->uas }}</td>
                                            <td>{{ $k->uts }}</td>
                                            <td>{{ $k->nilaistase }}</td>
                                            <td>{{ $k->totalnilai }}</td>
                                            <td>{{ $k->hasil }}</td>
                                            <td>{{ $k->ctn_semester }}</td>
                                            <td>{{ $k->ctn_karyailmiah }}</td>
                                            <td>{{ $k->ctn_tingkat }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer mt-n4">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">{{ __('message.tutup') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
                scrollX: true
            });
        });
    </script>

    <script>
        var translations = {
            deleteConfirmation: "{{ __('message.deleteConfirm') }}",
            cancel: "{{ __('message.cancel') }}",
            confirm: "{{ __('message.confirm') }}"
        };
    </script>
@endpush
