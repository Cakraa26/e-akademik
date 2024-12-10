@extends('layouts.app')

@section('title', __('message.psikomotorik'))

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
                            <div class="breadcrumb-item">{{ __('message.psikomotorik') }}</div>
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
                                <a class="btn btn-success {{ Request::is('data-psikomotorik/create') ? 'active' : '' }}"
                                    href="{{ route('data.psikomotorik.create') }}" data-toggle="tooltip"
                                    title="{{ __('message.tambah') }}"><i
                                        class="fas fa-plus pr-2"></i>{{ __('message.tambah') }}</a>
                            </div>
                        </div>

                        <form action="" method="GET">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="groupfk" class="form-label">{{ __('message.group') }}</label>
                                        <select class="form-select select2" id="groupfk" name="groupfk">
                                            <option value=""></option>
                                            @foreach ($group as $g)
                                                <option value="{{ $g->pk }}"
                                                    {{ Request::get('groupfk') == $g->pk ? 'selected' : '' }}>
                                                    {{ $g->nm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kategoriInput" class="form-label">{{ __('message.kategori') }}</label>
                                        <select class="form-select select2" id="kategorifk" name="kategorifk">
                                            <option value=""></option>
                                            @foreach ($kategori as $k)
                                                <option value="{{ $k->pk }}"
                                                    {{ Request::get('kategorifk') == $k->pk ? 'selected' : '' }}>
                                                    {{ $k->nm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-n4 mt-md-0">
                                    <div class="mb-3">
                                        <label>&nbsp;</label>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary mr-2">Filter <i
                                                    class="fas fa-sort-amount-up pl-1"></i></button>
                                            <a href="{{ route('data.psikomotorik.index') }}"
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
                                        <th>No</th>
                                        <th>{{ __('message.nama') }}</th>
                                        <th>{{ __('message.kategori') }}</th>
                                        <th>{{ __('message.subkategori') }}</th>
                                        <th>Status</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($motorik as $m)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $m->nm }}</td>
                                            <td>{{ $m->kategori->nm }}</td>
                                            <td>{{ $m->subkategori->nm }}</td>
                                            <td>{{ $m->aktif === 1 ? __('message.active') : __('message.inactive') }}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('data.psikomotorik.edit', $m->pk) }}"
                                                        class="btn btn-info {{ Request::is('data-psikomotorik/' . $m->pk . '/edit') ? 'active' : '' }}"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>


                                                    <form action="{{ route('data.psikomotorik.destroy', $m->pk) }}"
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
