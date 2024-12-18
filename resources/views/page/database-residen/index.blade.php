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
                            <div class="row">
                                <div class="col-md-3 mb-3 pr-md-0">
                                    <label class="form-label">{{ __('message.angkatan') }}</label>
                                    <select class="form-control select2" name="thnajaranfk" id="thnajaranfk">
                                        <option value=""></option>
                                        @foreach ($angkatan as $t)
                                            <option value="{{ $t->pk }}"
                                                {{ Request::get('thnajaranfk') == $t->pk || (!Request::get('thnajaranfk') && $t->aktif == 1) ? 'selected' : '' }}>
                                                {{ $t->nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 pr-md-0">
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
                                <div class="col-md-2 mb-3 pr-md-0">
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
                                <div class="col-md-2 mb-3 pr-md-0">
                                    <label>{{ __('message.statuskuliah') }}</label>
                                    <div class="d-flex mt-2">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="statuskuliah"
                                                value="1"
                                                {{ request()->get('statuskuliah') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                Aktif
                                            </label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="statuskuliah"
                                                value="3"
                                                {{ request()->get('statuskuliah') == '3' ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                Alumni
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statuskuliah"
                                                value="semua"
                                                {{ request()->get('statuskuliah') == 'semua' ? 'checked' : '' }}{{ is_null(request()->get('statuskuliah')) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                Semua
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1 mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('database.residen.index') }}" class="btn btn-secondary mr-1">Refresh
                                            <i class="fas fa-sync-alt pl-1"></i>
                                        </a>
                                        <button type="submit" class="btn btn-primary">Filter<i
                                                class="fa-solid fa-arrow-up-wide-short pl-1"></i></button>
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
