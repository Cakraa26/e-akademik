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
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="angkatanfk" class="form-label">{{ __('message.angkatan') }}</label>
                                        <select class="form-select select2" id="angkatanfk" name="angkatanfk">
                                            <option value=""></option>
                                            @foreach ($angkatan as $a)
                                                <option value="{{ $a->pk }}"
                                                    {{ Request::get('angkatanfk') == $a->pk ? 'selected' : '' }}>
                                                    {{ $a->nm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-form-label col-sm-3 pt-0">{{ __('message.statuskuliah') }}</div>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="statuskuliah"
                                                    id="gridRadios1" value="1"
                                                    {{ request()->input('statuskuliah') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Aktif
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="statuskuliah"
                                                    id="gridRadios1" value="3"
                                                    {{ request()->input('statuskuliah') == '3' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Alumni
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="statuskuliah"
                                                    id="gridRadios1" value="semua"
                                                    {{ request()->input('statuskuliah') == 'semua' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Semua
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="semesterInput" class="form-label">{{ __('message.semester') }}</label>
                                        <select class="form-select select2" id="semesterInput" name="semesterfk">
                                            <option value=""></option>
                                            @foreach ($semester as $k)
                                                <option value="{{ $k->pk }}"
                                                    {{ Request::get('semesterfk') == $k->pk ? 'selected' : '' }}>
                                                    {{ $k->semester }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label for="tingkatfk" class="form-label">{{ __('message.tingkat') }}</label>
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
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 mt-n4 mt-md-0">
                                    <div class="mb-3">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary mr-2">Filter <i
                                                    class="fas fa-sort-amount-up pl-1"></i></button>
                                            <a href="{{ route('database.residen.index') }}"
                                                class="btn btn-secondary">Refresh <i class="fas fa-sync-alt pl-1"></i></a>
                                        </div>
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
                                    @foreach ($dataresiden as $residen)
                                        <tr>
                                            <td>
                                                <div>
                                                    <a href="{{ route('database.residen.edit', $residen->pk) }}"
                                                        class="btn btn-info {{ Request::is('database-residen/' . $residen->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="{{ route('database-residen.show', $residen->pk) }}"
                                                        class="btn btn-dark {{ Request::is('database-residen/' . $residen->pk) ? 'active' : '' }}"><i
                                                            class="fa-solid fa-info"></i></a>
                                                </div>
                                            </td>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $residen->tahunajaran->nm }}</td>
                                            <td>{{ $residen->inisialresiden }}</td>
                                            <td>{{ $residen->nm }}</td>
                                            <td>{{ $residen->hp }}</td>
                                            <td>{{ $residen->alamattinggal }}</td>
                                            <td>{{ $residen->karyailmiah->nm }}</td>
                                            <td>
                                                @switch($residen->statuskuliah)
                                                    @case(1)
                                                        Mahasiswa
                                                    @break
                                                    @case(2)
                                                        Ditolak
                                                    @break
                                                    @case(3)
                                                        Alumni
                                                    @break
                                                    @case(4)
                                                        Cuti
                                                    @break
                                                    @default
                                                        Daftar
                                                @endswitch
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
