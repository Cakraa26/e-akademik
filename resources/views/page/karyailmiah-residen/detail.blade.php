@extends('layouts.app')

@section('title', __('message.detailkarya'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        i.fa-solid.fa-angle-right {
            color: #c0c2c3;
            margin: 0 8px;
        }

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
                <h1>{{ $tkaryailmiah->residen->nm }}</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('karyailmiahresiden.index') }}">{{ __('message.karyailmiah') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.detail') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row col-md-6 mb-2 mb-md-0">
                    <h2 class="section-title">Semester : {{ $tkaryailmiah->residen->semester }} <i
                            class="fa-solid fa-angle-right"></i>
                        {{ __('message.tingkat') }} : {{ $tkaryailmiah->residen->tingkat->kd }}</h2>
                </div>

                <div class="d-flex justify-content-end align-items-center mb-3">
                    <a class="btn btn-dark mr-1" href="{{ route('karyailmiahresiden.index') }}">
                        <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                    <button type="button" class="btn btn-primary mr-1" id="btnCetak">{{ __('message.cetak') }}<i
                            class='fas fa-print pl-2'></i></button>
                    <button type="button" class="btn btn-success" id="btnCetak">Excel<i
                            class="fas fa-file-excel pl-2"></i></button>
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
                                        <th>{{ __('message.tahapan') }}</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>Semester</th>
                                        <th>{{ __('message.tingkat') }}</th>
                                        <th>{{ __('message.ctn') }}</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($karya as $k)
                                        <tr id="row-{{ $k->t_karyailmiah_pk }}">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $k->nm }}</td>
                                            @if (!empty($k->file))
                                                <td>
                                                    <a href="{{ Storage::url($k->file) }}" download
                                                        class="btn btn-outline-success btn-sm"><i
                                                            class="fas fa-download"></i></a>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                            @if (!empty($k->t_karyailmiah_pk))
                                                <form
                                                    action="{{ route('karyailmiahresiden.update', ['pk' => $k->t_karyailmiah_pk]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <td>
                                                        <label class="custom-switch pl-0">
                                                            <input type="checkbox" class="custom-switch-input" name="stssudah" value="2"
                                                                id="switch-{{ $k->t_karyailmiah_pk }}"
                                                                {{ $k->stssudah === 2 ? 'checked' : '' }} disabled>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </td>
                                                    <td>{{ $k->semester }}</td>
                                                    <td>{{ $k->tingkat }}</td>
                                                    <td>
                                                        <span class="view"
                                                            id="ctnfile-{{ $k->t_karyailmiah_pk }}">{{ $k->ctnfile }}</span>
                                                        <input type="text" name="ctnfile" value="{{ $k->ctnfile }}"
                                                            class="form-control edit-field" style="display:none;">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            onclick="toggleEdit({{ $k->t_karyailmiah_pk }})"
                                                            id="edit-btn-{{ $k->t_karyailmiah_pk }}">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary btn-sm mb-1"
                                                            id="save-btn-{{ $k->t_karyailmiah_pk }}" style="display:none;">
                                                            <i class="fas fa-save"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="cancelEdit({{ $k->t_karyailmiah_pk }})"
                                                            id="cancel-btn-{{ $k->t_karyailmiah_pk }}"
                                                            style="display:none;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                </form>
                                            @else
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endif
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
            const switchInput = document.getElementById('switch-' + pk);
            
            row.querySelectorAll('.view').forEach(view => view.style.display = 'none');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'block');
            switchInput.disabled = false;
            document.getElementById('edit-btn-' + pk).style.display = 'none';
            document.getElementById('save-btn-' + pk).style.display = 'inline';
            document.getElementById('cancel-btn-' + pk).style.display = 'inline';
        }

        function cancelEdit(pk) {
            const row = document.getElementById('row-' + pk);
            const switchInput = document.getElementById('switch-' + pk);
            row.querySelectorAll('.view').forEach(view => view.style.display = 'inline');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'none');
            switchInput.disabled = true;
            document.getElementById('edit-btn-' + pk).style.display = 'inline';
            document.getElementById('save-btn-' + pk).style.display = 'none';
            document.getElementById('cancel-btn-' + pk).style.display = 'none';
        }
    </script>
@endpush
