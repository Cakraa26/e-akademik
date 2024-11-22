@extends('layouts.app')

@section('title', __('message.uploadfile'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
    <style>
        .btn.btn-sm {
            border-radius: 50%;
            width: 28px;
            height: 28px;
            padding: 0;
            line-height: 25px;
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
                            <div class="breadcrumb-item">{{ __('message.uploadfile') }}</div>
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
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible show fade" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            {{-- Alert End --}}

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-5 mb-md-0">
                                <a class="btn btn-success {{ Request::is('upload-file/create') ? 'active' : '' }}"
                                    href="{{ route('upload.file.create') }}" data-toggle="tooltip"
                                    title="{{ __('message.tambah') }}"><i
                                        class="fas fa-plus pr-2"></i>{{ __('message.tambah') }}</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table-striped table" id="myTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.nama') }}</th>
                                        <th>{{ __('message.ctn') }}</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $file->nm }}</td>
                                            <td>{{ $file->ctn }}</td>
                                            <td class="text-nowrap">
                                                {{-- <a href="{{ route('upload.file.show', $file->pk) }}"
                                                    class="btn btn-sm btn-secondary"><i class="fa fa-eye"></i></a> --}}
                                                <a href="{{ route('upload.file.show', $file->pk) }}"
                                                    class="btn btn-sm btn-primary"><i class="fa fa-download"></i></a>
                                            </td>
                                            <td>
                                                <label class="custom-switch pl-0">
                                                    <input type="checkbox" name="aktif[{{ $file->pk }}]" value="2"
                                                        class="custom-switch-input"
                                                        {{ $file->aktif == 1 ? 'checked' : '' }} disabled>
                                                    <span class="custom-switch-indicator"></span>
                                                </label>
                                            </td>
                                            <td class="text-nowrap">
                                                <div>
                                                    <a href="{{ route('upload.file.edit', $file->pk) }}"
                                                        class="btn btn-info {{ Request::is('upload-file/' . $file->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fas fa-pen-to-square"></i></a>
                                                    <form action="{{ route('upload.file.destroy', $file->pk) }}"
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
