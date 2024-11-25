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
                                    href="{{ route('absensi.index') }}">{{ __('message.absensi') }}</a>
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
                                            <td>{{ date('Y-m-d', strtotime($a->check_in)) ?? '-' }}</td>
                                            <td>{{ date('H.i', strtotime($a->check_in)) ?? '-' }}</td>
                                            <td>{{ date('H.i', strtotime($a->check_out)) ?? '-' }}</td>
                                            <td>{{ $a->terlambat }}</td>
                                            <td>{{ $a->alpa }}</td>
                                            <td>{{ $a->ctn }}</td>
                                            <td></td>
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
