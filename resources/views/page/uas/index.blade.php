@extends('layouts.app')

@section('title', 'UAS')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
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
                            <div class="breadcrumb-item">UAS</div>
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

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET">
                            @csrf
                            <div class="row mb-3">
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
                                <div class="col-md-4 mb-3 pr-md-0">
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
                                <div class="col-8 col-md-3 mb-3 pr-0">
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
                                <div class="col-3 col-md-2 mb-3">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-danger mr-1"><i
                                                class="fas fa-search"></i></button>
                                        <a href="{{ route('uas.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table-striped table" id="myTable" style="width: 100%">
                                <thead>
                                    <tr class="text-center">
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">{{ __('message.nama') }}</th>
                                        <th colspan="2">MCQ</th>
                                        <th colspan="7">OSCE</th>
                                        <th rowspan="2">{{ __('message.hasiluas') }}</th>
                                        <th colspan="4">{{ __('message.totaluasuts') }}</th>
                                        <th rowspan="2">{{ __('message.hasil') }}</th>
                                        <th rowspan="2">{{ __('message.keterangansemester') }}</th>
                                        <th rowspan="2">{{ __('message.keterangantingkat') }}</th>
                                        <th rowspan="2">{{ __('message.aksi') }}</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>{{ __('message.benarmcq') }}</th>
                                        <th>MCQ</th>
                                        <th>PED</th>
                                        <th>TRAUMA</th>
                                        <th>{{ __('message.spine') }}</th>
                                        <th>{{ __('message.lower') }}</th>
                                        <th>TUMOR</th>
                                        <th>{{ __('message.tangan') }}</th>
                                        <th>{{ __('message.hasilosce') }}</th>
                                        <th>UAS (20%)</th>
                                        <th>UTS (20%)</th>
                                        <th>STASE (60%)</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($kelas as $k)
                                        <tr id="row-{{ $k->pk }}"
                                            @if ($k->tingkatfk == 1 || $k->tingkatfk == 2) style="background-color: #E98580;" 
                                            @elseif($k->tingkatfk == 3) style="background-color: #F4D06F;" 
                                            @elseif($k->tingkatfk == 4 || $k->tingkatfk == 5) style="background-color: #A4C686;" @endif>
                                            <form action="{{ route('uas.update', $k->pk) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <td>{{ $no++ }}</td>
                                                <td class="text-nowrap">{{ $k->residen->nm ?? '-' }}</td>
                                                <td>
                                                    <span class="view"
                                                        id="mcqbenar_uas-{{ $k->pk }}">{{ $k->mcqbenar_uas }}</span>
                                                    <input type="text" name="mcqbenar_uas"
                                                        value="{{ $k->mcqbenar_uas }}" class="form-control edit-field"
                                                        style="display:none;">
                                                </td>
                                                <td>{{ $k->mcq_uas }}</td>
                                                <td>
                                                    <span class="view"
                                                        id="osce_ped_uas-{{ $k->pk }}">{{ $k->osce_ped_uas }}</span>
                                                    <input type="text" name="osce_ped_uas"
                                                        value="{{ $k->osce_ped_uas }}" class="form-control edit-field"
                                                        style="display:none;">
                                                </td>
                                                <td>
                                                    <span class="view"
                                                        id="osce_trauma_uas-{{ $k->pk }}">{{ $k->osce_trauma_uas }}</span>
                                                    <input type="text" name="osce_trauma_uas"
                                                        value="{{ $k->osce_trauma_uas }}" class="form-control edit-field"
                                                        style="display:none;">
                                                </td>
                                                <td>
                                                    <span class="view"
                                                        id="osce_spine_uas-{{ $k->pk }}">{{ $k->osce_spine_uas }}</span>
                                                    <input type="text" name="osce_spine_uas"
                                                        value="{{ $k->osce_spine_uas }}" class="form-control edit-field"
                                                        style="display:none;">
                                                </td>
                                                <td>
                                                    <span class="view"
                                                        id="osce_lower_uas-{{ $k->pk }}">{{ $k->osce_lower_uas }}</span>
                                                    <input type="text" name="osce_lower_uas"
                                                        value="{{ $k->osce_lower_uas }}" class="form-control edit-field"
                                                        style="display:none;">
                                                </td>
                                                <td>
                                                    <span class="view"
                                                        id="osce_tumor_uas-{{ $k->pk }}">{{ $k->osce_tumor_uas }}</span>
                                                    <input type="text" name="osce_tumor_uas"
                                                        value="{{ $k->osce_tumor_uas }}" class="form-control edit-field"
                                                        style="display:none;">
                                                </td>
                                                <td>
                                                    <span class="view"
                                                        id="osce_hand_uas-{{ $k->pk }}">{{ $k->osce_hand_uas }}</span>
                                                    <input type="text" name="osce_hand_uas"
                                                        value="{{ $k->osce_hand_uas }}" class="form-control edit-field"
                                                        style="display:none;">
                                                </td>
                                                <td>{{ $k->hasil_osce_uas }}</td>
                                                <td>{{ $k->uas }}</td>
                                                <td>{{ $k->persenuas }}</td>
                                                <td>{{ $k->persenuts }}</td>
                                                <td>{{ $k->persenstase }}</td>
                                                <td>{{ $k->totalnilai }}</td>
                                                <td>
                                                    @if ($k->status_uas === 'REMIDI')
                                                        <span class="badge badge-danger">REMIDI</span>
                                                    @elseif($k->status_uas === 'LULUS')
                                                        <span class="badge badge-success">LULUS</span>
                                                    @else
                                                        <span></span>
                                                    @endif
                                                </td>
                                                <td>{{ $k->ctn_semester }}</td>
                                                <td>{{ $k->ctn_tingkat }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="toggleEdit({{ $k->pk }})"
                                                        id="edit-btn-{{ $k->pk }}">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-primary btn-sm mb-1"
                                                        id="save-btn-{{ $k->pk }}" style="display:none;">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="cancelEdit({{ $k->pk }})"
                                                        id="cancel-btn-{{ $k->pk }}" style="display:none;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </form>
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
