@extends('layouts.app')

@section('title', __('message.harikerja'))

@push('style')
    <!-- CSS Libraries -->
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
                            <div class="breadcrumb-item">{{ __('message.harikerja') }}</div>
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
            @elseif (session('warning'))
                <div class="alert alert-warning alert-dismissible show fade" role="alert">
                    <strong>{{ __('message.warning') }}!</strong> {{ session('warning') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            {{-- Alert End --}}

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-5 mb-md-0">
                                <a class="btn btn-success {{ Request::is('hari-kerja/create') ? 'active' : '' }}"
                                    href="{{ route('hari.kerja.create') }}" data-toggle="tooltip"
                                    title="{{ __('message.tambah') }}"><i
                                        class="fas fa-plus pr-2"></i>{{ __('message.tambah') }}</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table-striped table nowrap" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>{{ __('message.hari') }}</th>
                                        <th>{{ __('message.masuk') }}</th>
                                        <th>{{ __('message.keluar') }}</th>
                                        <th>Status</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($thn as $hr)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $hr->nm }}</td>
                                            <td>{{ date('H:i', strtotime($hr->jammasuk)) }}</td>
                                            <td>{{ date('H:i', strtotime($hr->jamselesai)) }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $hr->stsaktif ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $hr->stsaktif ? __('message.active') : __('message.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('hari.kerja.edit', $hr->pk) }}"
                                                        class="btn btn-info {{ Request::is('hari-kerja/' . $hr->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fas fa-pen-to-square"></i></a>


                                                    <form action="{{ route('hari.kerja.destroy', $hr->pk) }}"
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
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.boostrap4.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>

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
