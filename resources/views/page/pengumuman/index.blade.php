@extends('layouts.app')

@section('title', __('message.pengumuman'))

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
                            <div class="breadcrumb-item">{{ __('message.pengumuman') }}</div>
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
                        <div class="row mb-4">
                            <div class="col-md-5 mb-md-0">
                                <a class="btn btn-success {{ Request::is('pengumuman/create*') ? 'active' : '' }}"
                                    href="{{ route('pengumuman.create') }}" data-toggle="tooltip"
                                    title="{{ __('message.tambah') }}"><i
                                        class="fas fa-plus pr-2"></i>{{ __('message.tambah') }}</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table-striped table nowrap" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.tglbuat') }}</th>
                                        <th>{{ __('message.tglberlaku') }}</th>
                                        <th>{{ __('message.judul') }}</th>
                                        <th>{{ __('message.active') }}</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengumuman as $s)
                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ date('d/m/Y', strtotime($s->tglbuat)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($s->tglsampai)) }}</td>
                                            <td>{{ $s->judul }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $s->aktif === 1 ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $s->aktif === 1 ? __('message.active') : __('message.inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('pengumuman.edit', $s->pk) }}"
                                                        class="btn btn-info {{ Request::is('pengumuman/' . $s->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>

                                                    <form action="{{ route('pengumuman.destroy', $s->pk) }}" method="POST"
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