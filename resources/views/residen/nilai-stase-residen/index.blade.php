@extends('layouts.app')

@section('title', __('message.nilaistase'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.css" rel="stylesheet">
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
                            <div class="breadcrumb-item">{{ __('message.nilaistase') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <form action="" method="GET">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-8 col-md-3 mb-3 pr-0">
                            <select class="form-control select2" name="thnajaranfk" id="thnajaranfk">
                                @foreach ($thnajaran as $t)
                                    <option value="{{ $t->pk }}"
                                        {{ Request::get('thnajaranfk') == $t->pk || (!Request::get('thnajaranfk') && $t->aktif == 1) ? 'selected' : '' }}>
                                        {{ $t->nm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3 col-md-2">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-danger mr-1"><i class="fas fa-search"></i></button>
                                <a href="{{ route('nilai.stase.residen.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

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

                @if ($grup->isNotEmpty())
                    @foreach ($grup as $key => $nilai)
                        <div class="card">
                            <div class="card-body">
                                @php
                                    [$bulan, $tahun] = explode('-', $key);

                                    $tanggal = date('F Y', strtotime("$tahun-$bulan"));

                                @endphp
                                <h2 class="section-title">{{ $tanggal }}</h2>
                                <div class="table-responsive">
                                    <table class="table-striped table myTable" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Stase</th>
                                                <th>{{ __('message.dosen') }}</th>
                                                <th>{{ __('message.nilai') }}</th>
                                                <th>Status</th>
                                                @if ($nilai->first()->stsnilai != 3 && $nilai->first()->nilai == 0)
                                                    <th>{{ __('message.aksi') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nilai as $n)
                                                <tr
                                                    @if ($colorRed) style="background-color: #E98580;" @endif>
                                                    <td>{{ $n->stase->nm }}</td>
                                                    <td>{{ $n->dosen->nm }}</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="nilai[{{ $n->pk }}]"
                                                                {{ $n->nilai > 0 ? 'checked' : '' }} disabled>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($n->stsnilai == 0)
                                                            Belum dinilai
                                                        @elseif ($n->stsnilai == 1)
                                                            Request Approved
                                                        @elseif ($n->stsnilai == 2)
                                                            Approved
                                                        @elseif ($n->stsnilai == 3)
                                                            Cancel Approved
                                                        @endif
                                                    </td>
                                                    @if ($n->stsnilai != 3 && $n->nilai == 0)
                                                        <td>
                                                            <button class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                                                data-bs-target="#uploadModal{{ $n->pk }}"><i
                                                                    class="fas fa-upload"></i></button>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                        <h5>{{ __('message.nodata') }}</h5>
                    </div>
                @endif

            </div>
        </section>

        @foreach ($grup as $key => $nilai)
            @foreach ($nilai as $n)
                <div class="modal fade" id="uploadModal{{ $n->pk }}" tabindex="-1"
                    aria-labelledby="uploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>{{ __('message.uploadfile') }}</h5>
                            </div>
                            <form id="form" action="{{ route('nilai.stase.residen.upload') }}" method="POST"
                                enctype="multipart/form-data" data-parsley-validate>
                                @csrf
                                <div class="modal-body mt-n2">
                                    <input type="hidden" name="stasefk" value="{{ $n->pk }}">
                                    <input type="file" class="form-control" name="fileStase" required
                                        data-parsley-required-message="{{ __('message.filerequired') }}">
                                </div>
                                <div class="modal-footer mt-n3">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">{{ __('message.cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('message.upload') }}</button>
                                </div>
                            </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('.myTable').DataTable({
                scrollX: true,
                searching: false
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            })
        });
    </script>
@endpush
