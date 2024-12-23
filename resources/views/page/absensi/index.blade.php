@extends('layouts.app')

@section('title', __('message.absensi'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
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
                            <div class="breadcrumb-item">{{ __('message.absensi') }}</div>
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
                                    <label for="thnajaranfk" class="form-label">{{ __('message.thnajaran') }}</label>
                                    <select class="form-control select2" name="thnajaranfk" id="thnajaranfk">
                                        <option value=""></option>
                                        @foreach ($thnajaran as $t)
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
                                <div class="col-md-2 mb-3 pr-md-0 mt-n3 mt-md-0">
                                    <label class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control" name="check_in"
                                        value="{{ Request::get('check_in') ?: date('Y-m-d') }}">
                                </div>
                                <div class="col-md-2 mb-3 mt-n3 mt-md-0">
                                    <label class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control" name="check_out"
                                        value="{{ Request::get('check_out') ?: date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('absensi.index') }}" class="btn btn-secondary mr-1">Refresh
                                            <i class="fas fa-sync-alt pl-1"></i>
                                        </a>
                                        <button type="submit" class="btn btn-primary">Filter<i
                                                class="fa-solid fa-arrow-up-wide-short pl-1"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-5 mb-md-0">
                                <a class="btn btn-success {{ Request::is('absensi/create') ? 'active' : '' }}"
                                    href="{{ route('absensi.create') }}" data-toggle="tooltip"
                                    title="{{ __('message.tambah') }}"><i
                                        class="fas fa-plus pr-2"></i>{{ __('message.tambah') }}</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table-striped table" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.tanggal') }}</th>
                                        <th>{{ __('message.nama') }}</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>{{ __('message.terlambat') }}</th>
                                        <th>{{ __('message.alpa') }}</th>
                                        <th>{{ __('message.ctn') }}</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($absen as $a)
                                        <tr @if ($a->alpa === 1) style="background-color: #E98580;" @endif>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ date('d/m/Y', strtotime($a->check_in)) }}</td>
                                            <td>{{ $a->residen->nm }}</td>
                                            <td>
                                                @if ($a->loc_in !== null)
                                                    <a style="cursor: pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#checkinModal{{ $a->pk }}">
                                                        {{ date('H.i', strtotime($a->check_in)) }}
                                                    </a>
                                                @else
                                                    {{ date('H.i', strtotime($a->check_in)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($a->loc_out !== null)
                                                    <a style="cursor: pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#checkoutModal{{ $a->pk }}">
                                                        {{ date('H.i', strtotime($a->check_out)) }}
                                                    </a>
                                                @else
                                                    {{ $a->loc_out ? date('H.i', strtotime($a->check_out)) : '-' }}
                                                @endif
                                            </td>
                                            <td>{{ $a->terlambat }}</td>
                                            <td>{{ $a->alpa }}</td>
                                            <td>{{ $a->ctn }}</td>
                                            <td class="text-nowrap">
                                                <div>
                                                    <a href="{{ route('absensi.edit', $a->pk) }}"
                                                        class="btn btn-info {{ Request::is('data-group/' . $a->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>

                                                    <form action="{{ route('absensi.destroy', $a->pk) }}" method="POST"
                                                        style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger swal-6"><i
                                                                class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
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

        {{-- Modal Check In --}}
        @foreach ($absen as $a)
            <div class="modal fade" id="checkinModal{{ $a->pk }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="row mb-n1">
                                <div class="col-12 col-md-4 pt-2 text-center" style="color: black">
                                    <img src="{{ Storage::url($a->photo_in) }}" class="mb-3"
                                        style="width: 150px; height: 150px; object-fit: cover;"
                                        onerror="this.onerror=null;this.src='{{ asset('img/noimage.jpg') }}';">
                                    <p class="mb-0">{{ $a->residen->nm }}</p>
                                    <p class="mb-0">Semester {{ $a->semester->semester }}</p>
                                    <p class="mb-0">{{ $a->tingkat->kd }}</p>
                                </div>
                                <div class="col-md-8">
                                    <iframe src="https://maps.google.com/maps?q={{ $a->loc_in }}&output=embed"
                                        width="100%" height="260px" frameborder="0" style="border: 0;"
                                        allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Check Out --}}
            <div class="modal fade" id="checkoutModal{{ $a->pk }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="row mb-n1">
                                <div class="col-12 col-md-4 pt-2 text-center" style="color: black">
                                    <img src="{{ Storage::url($a->photo_out) }}" class="mb-3"
                                        style="width: 150px; height: 150px; object-fit: cover;"
                                        onerror="this.onerror=null;this.src='{{ asset('img/noimage.jpg') }}';">
                                    <p class="mb-0">{{ $a->residen->nm }}</p>
                                    <p class="mb-0">Semester {{ $a->semester->semester }}</p>
                                    <p class="mb-0">{{ $a->tingkat->kd }}</p>
                                </div>
                                <div class="col-md-8">
                                    <iframe src="https://maps.google.com/maps?q={{ $a->loc_out }}&output=embed"
                                        width="100%" height="260px" frameborder="0" style="border: 0;"
                                        allowfullscreen=""></iframe>
                                </div>
                            </div>
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
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
