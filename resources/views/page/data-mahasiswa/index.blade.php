@extends('layouts.app')
@section('title', __('message.calonresiden'))

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
                            <div class="breadcrumb-item">{{ __('message.calonresiden') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <h2 class="section-title2 text-center">{{ $thnajaran->nm }}</h2>
                @if ($count > 0)
                    <div class="col-12 col-md-4 px-0 text-center alert alert-warning alert-dismissible show fade" role="alert">
                       <strong><i class="fa-solid fa-triangle-exclamation pr-1"></i></strong> {{ __('message.ada') }} {{ $count }} {{ __('message.cek') }}
                    </div>
                @endif
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                    <strong>{{ __('message.success') }}!</strong> {{ session('success') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @elseif (session('warning'))
                <div class="alert alert-warning alert-dismissible show fade" role="alert">
                    <strong>Peringatan!</strong> {{ session('warning') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            {{-- Alert End --}}

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.tgldaftar') }}</th>
                                        <th>{{ __('message.inisial') }}</th>
                                        <th>{{ __('message.nmresiden') }}</th>
                                        <th>{{ __('message.hp') }}</th>
                                        <th>{{ __('message.asalfakultas') }}</th>
                                        <th>{{ __('message.thnlulus') }}</th>
                                        <th class="text-nowrap">{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residen as $r)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d/m/Y', strtotime($r->dateadded)) }}</td>
                                            <td>{{ $r->inisialresiden }}</td>
                                            <td>{{ $r->nm }}</td>
                                            <td>{{ $r->hp }}</td>
                                            <td>{{ $r->asalfk }}</td>
                                            <td>{{ $r->thnlulus }}</td>
                                            <td class="text-nowrap">
                                                <div>
                                                    <form action="{{ route('data.mahasiswa.update', $r->pk) }}"
                                                        method="POST" style="display: inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fas fa-check"></i></button>
                                                    </form>

                                                    <a href="{{ route('data.mahasiswa.show', $r->pk) }}"
                                                        class="btn btn-secondary {{ Request::is('data-mahasiswa/' . $r->pk . '/show') ? 'active' : '' }}"><i
                                                            class="fa-solid fa-eye"></i></a>
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
@endpush
