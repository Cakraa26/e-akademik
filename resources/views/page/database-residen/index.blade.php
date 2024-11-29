@extends('layouts.app')

@section('title', __('message.databaseresiden'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
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
                            <div class="breadcrumb-item">{{ __('message.databaseresiden') }}</div>
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
                            <div class="row mb-4">
                                <div class="col-md-3 pr-0">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('message.angkatan') }}</label>
                                        <select class="form-select select2" id="thnajaranfk" name="thnajaranfk">
                                            <option value=""></option>
                                            @foreach ($angkatan as $a)
                                                <option value="{{ $a->pk }}"
                                                    {{ Request::get('thnajaranfk') == $a->pk || (!Request::get('thnajaranfk') && $a->aktif == 1) ? 'selected' : '' }}>
                                                    {{ $a->nm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-0">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('message.tingkat') }}</label>
                                        <select class="form-select select2" id="tingkatfk" name="tingkatfk">
                                            <option value=""></option>
                                            @foreach ($tingkat as $t)
                                                <option value="{{ $t->pk }}"
                                                    {{ Request::get('tingkatfk') == $t->pk ? 'selected' : '' }}>
                                                    {{ $t->nm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('message.semester') }}</label>
                                        <select class="form-select select2" id="semester" name="semester">
                                            <option value=""></option>
                                            @foreach ($semester as $s)
                                                <option value="{{ $s->pk }}"
                                                    {{ Request::get('semester') == $s->pk ? 'selected' : '' }}>
                                                    {{ $s->semester }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 pr-0">
                                    <div>{{ __('message.statuskuliah') }}</div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statuskuliah" id="gridRadios1"
                                            value="1" {{ request()->input('statuskuliah') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios1">
                                            Aktif
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statuskuliah" id="gridRadios1"
                                            value="3" {{ request()->input('statuskuliah') == '3' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios1">
                                            Alumni
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="statuskuliah" id="gridRadios1"
                                            value="semua"
                                            {{ request()->input('statuskuliah') == 'semua' ? 'checked' : '' }} checked>
                                        <label class="form-check-label" for="gridRadios1">
                                            Semua
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 pr-0">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-danger mr-1"><i
                                                class="fas fa-search"></i></button>
                                        <a href="{{ route('database.residen.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table-striped table nowrap" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('message.aksi') }}</th>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.angkatan') }}</th>
                                        <th>{{ __('message.inisial') }}</th>
                                        <th>{{ __('message.nama') }}</th>
                                        <th>{{ __('message.hp') }}</th>
                                        <th>{{ __('message.alamat') }}</th>
                                        <th>{{ __('message.karyailmiah') }}</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataresiden as $r)
                                        <tr
                                            @if ($r->tingkatfk == 1 || $r->tingkatfk == 2) style="background-color: #E98580;"
                                                @elseif ($r->tingkatfk == 3)
                                                 style="background-color: #F4D06F;"
                                                  @elseif ($r->tingkatfk == 4)
                                                 style="background-color: #A4C686;" @endif>
                                            <td>
                                                <div>
                                                    <a href="{{ route('database.residen.edit', $r->pk) }}"
                                                        class="btn btn-info {{ Request::is('database-residen/' . $r->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="{{ route('database-residen.show', $r->pk) }}"
                                                        class="btn btn-secondary {{ Request::is('database-residen/' . $r->pk) ? 'active' : '' }}"><i
                                                            class="fa-solid fa-eye"></i></a>
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $r->tahunajaran->nm }}</td>
                                            <td>{{ $r->inisialresiden }}</td>
                                            <td>{{ $r->nm }}</td>
                                            <td>{{ $r->hp }}</td>
                                            <td>{{ $r->alamattinggal }}</td>
                                            <td>{{ $r->karyailmiah->nm }}</td>
                                            <td>
                                                @if ($r->statuskuliah === 1)
                                                    Mahasiswa
                                                @elseif ($r->statuskuliah === 2)
                                                    Ditolak
                                                @elseif ($r->statuskuliah === 3)
                                                    Alumni
                                                @elseif ($r->statuskuliah === 4)
                                                    Cuti
                                                @else
                                                    Daftar
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.boostrap4.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
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
