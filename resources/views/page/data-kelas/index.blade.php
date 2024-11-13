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

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3 pr-0">
                                    <label for="thnajaranfk" class="form-label">{{ __('message.thnajaran') }}</label>
                                    <select class="form-control select2" name="thnajaranfk" id="thnajaranfk"
                                        onchange="updateInput(this.value)">
                                        @foreach ($thnajaran as $t)
                                            <option value="{{ $t->pk }}"
                                                {{ Request::get('thnajaranfk') == $t->pk || (!Request::get('thnajaranfk') && $t->aktif == 1) ? 'selected' : '' }}>
                                                {{ $t->nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 pr-0">
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
                                        <a href="{{ route('data.kelas.index') }}" class="btn btn-secondary">
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

                @if ($kelas->isNotEmpty())
                    @foreach ($kelas as $semester => $dataKelas)
                        @if (request('semester') == null || request('semester') == $semester)
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="section-title">Semester : {{ $semester }}</h2>
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
                                                @foreach ($dataKelas as $k)
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
                    @if ($selectTahunAjaran && $selectTahunAjaran->aktif == 1)
                        <form action="{{ route('data.kelas.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="select_thnajaran" id="select_thnajaran">
                            <div class="d-flex justify-content-center mt-3">
                                <button class="btn btn-primary" type="submit"><i
                                        class="fas fa-plus pr-2"></i>{{ __('message.generateclass') }}</button>
                            </div>
                        </form>
                    @endif
                @endif

            </div>
        </section>

        {{-- Modal Detail --}}
        @foreach ($kelas as $semester => $dataKelas)
            @foreach ($dataKelas as $k)
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
                                <div class="table-responsive">
                                    <table border="1" class="table-striped table">
                                        <thead>
                                            <tr class="text-center">
                                                <th colspan="2">MCQ</th>
                                                <th colspan="7">OSCE</th>
                                                <th rowspan="2">{{ __('message.hasiluas') }}</th>
                                                <th colspan="4">{{ __('message.totaluasuts') }}</th>
                                                <th rowspan="2">{{ __('message.hasil') }}</th>
                                                <th rowspan="2">{{ __('message.keterangansemester') }}</th>
                                                <th rowspan="2">{{ __('message.keterangankarya') }}</th>
                                                <th rowspan="2">{{ __('message.keterangantingkat') }}</th>
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
        function updateInput(value) {
            const selectThnajaran = document.getElementById('select_thnajaran');
            if (selectThnajaran) {
                selectThnajaran.value = value;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let selectElement = document.getElementById('thnajaranfk');
            if (selectElement) {
                let initialValue = selectElement.value;
                updateInput(initialValue);
            }
        });
    </script>
@endpush
