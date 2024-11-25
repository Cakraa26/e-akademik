@extends('layouts.app')

@section('title', __('message.detailabsensi'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('daftar.absensi.index') }}">{{ __('message.dftabsensi') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.detail') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.residen') }}</label>
                        <h2 class="section-title2">{{ $residen->nm }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">Semester</label>
                        <h2 class="section-title2">{{ $residen->semester }}</h2>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.tingkat') }}</label>
                        <h2 class="section-title2">{{ $residen->tingkat->kd }}</h2>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade" role="alert">
                        <strong>{{ __('message.success') }}!</strong> {{ session('success') }}
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.tanggal') }}</th>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>{{ __('message.terlambat') }}</th>
                                        <th>{{ __('message.alpa') }}</th>
                                        <th>{{ __('message.ctn') }}</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($absen as $a)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ date('d-m-Y', strtotime($a->check_in)) ?? '-' }}</td>
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
                                                    {{ date('H.i', strtotime($a->check_out)) }}
                                                @endif
                                            </td>
                                            <td>{{ $a->terlambat }}</td>
                                            <td>{{ $a->alpa }}</td>
                                            <td>{{ $a->ctn }}</td>
                                            <td>
                                                <div>
                                                    <button class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#updateModal{{ $a->pk }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></button>

                                                    <form action="{{ route('daftar.absensi.destroy', $a->pk) }}"
                                                        method="POST" style="display: inline">
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

        @foreach ($absen as $a)
            <!-- Modal Update -->
            <div class="modal fade" id="updateModal{{ $a->pk }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('daftar.absensi.update', $a->pk) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4 row align-items-center">
                                            <label class="col-sm-3">Check-In</label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control" name="check_in"
                                                    id="check_in" value="{{ old('check_in', $a->check_in) }}" required
                                                    data-parsley-required-message="{{ __('message.checkinrequired') }}">
                                            </div>
                                        </div>
                                        <div class="mb-4 mb-md-0 row align-items-center">
                                            <label for="ctn" class="col-sm-3">{{ __('message.ctn') }}</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="ctn" id="ctn"
                                                    data-parsley-required-message="{{ __('message.ctnrequired') }}" style="height: 100px">{{ old('ctn', $a->ctn) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4 row align-items-center">
                                            <label class="col-sm-3">Check-Out</label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control" name="check_out"
                                                    id="check_out" value="{{ old('check_out', $a->check_out) }}" required
                                                    data-parsley-required-message="{{ __('message.checkoutrequired') }}">
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <label class="col-sm-3 mr-3 d-none d-sm-block">&nbsp;</label>
                                            <div class="form-check ml-3 ml-md-0">
                                                <input class="form-check-input" type="checkbox" name="alpa"
                                                    value="1" {{ old('alpa', $a->alpa) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ __('message.alpa') }}
                                                    / {{ __('message.tanpaabsen') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mt-n3">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('message.cancel') }}</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('message.simpan') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Check In --}}
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
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
