@extends('layouts.app')

@section('title', __('message.ktgmotorik'))

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
                            <div class="breadcrumb-item">{{ __('message.ktgmotorik') }}</div>
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
                                <a class="btn btn-success {{ Request::is('kategori-psikomotorik/create') ? 'active' : '' }}"
                                    href="{{ route('kategori.psikomotorik.create') }}" data-toggle="tooltip"
                                    title="{{ __('message.tambah') }}"><i
                                        class="fas fa-edit pr-2"></i>{{ __('message.tambah') }}</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table-striped table nowrap" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.nama') }}</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($ktgmotorik as $k)
                                        <tr>
                                            <th>{{ $no++ }}</th>
                                            <td>{{ $k->nm }}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('kategori.psikomotorik.edit', $k->pk) }}"
                                                        class="btn btn-info {{ Request::is('kategori.psikomotorik/' . $k->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fas fa-pencil-alt"></i></a>

                                                    <form action="{{ route('kategori.psikomotorik.destroy', $k->pk) }}" method="POST"
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
