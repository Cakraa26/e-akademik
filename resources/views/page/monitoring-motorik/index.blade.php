@extends('layouts.app')

@section('title', __('message.mngmotorik'))

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
                            <div class="breadcrumb-item">{{ __('message.mngmotorik') }}</div>
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
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
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
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="thnajaranfk" class="form-label">{{ __('message.thnajaran') }}</label>
                                        <select class="form-select select2" id="thnajaranfk" name="thnajaranfk">
                                            <option value=""></option>
                                            @foreach ($thnajaran as $t)
                                                <option value="{{ $t->pk }}"
                                                    {{ Request::get('thnajaranfk') == $t->pk ? 'selected' : '' }}>
                                                    {{ $t->nm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-3 mt-n4 mt-md-0">
                                    <div class="mb-3">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary mr-2">Filter <i
                                                    class="fas fa-sort-amount-up pl-1"></i></button>
                                            <a href="{{ route('monitoring.index') }}"
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
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.inisial') }}</th>
                                        <th>{{ __('message.nama') }}</th>
                                        <th>Semester</th>
                                        <th>{{ __('message.tingkat') }}</th>
                                        <th>{{ __('message.aksi') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($residen as $r)
                                        <tr>
                                            <th>{{ $no++ }}</th>
                                            <td>{{ $r->inisialresiden }}</td>
                                            <td>{{ $r->nm }}</td>
                                            <td>{{ $r->semester }}</td>
                                            <td>{{ $r->tingkat->kd }}</td>
                                            <td>Need Aprroved</td>
                                            <td>
                                                <a href="{{ route('monitoring.detail', $r->pk) }}"
                                                    class="btn btn-dark btn-table {{ Request::is('monitoring-motorik/' . $r->pk . '/detail') ? 'active' : '' }}"><i
                                                        class="fas fa-info"></i></a>
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
