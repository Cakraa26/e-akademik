@extends('layouts.app')
@section('title', __('message.detailpendaftaranresiden'))

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
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('data.mahasiswa.index') }}">{{ __('message.residen') }}</a></div>
                            <div class="breadcrumb-item">{{ __('message.detailpendaftaranresiden') }}</div>
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
                    <strong>Peringatan!</strong> {{ session('warning') }}
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            {{-- Alert End --}}

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3">
                                <p>Residen : {{ $residen->nm }}</p>
                            </div>
                            <div class="col-md-3">
                                <p>
                                    <span class="mr-2">Semester : {{ $residen->semester }}</span>
                                    <span>Tingkat : {{ $residen->tingkat->kd }}</span>
                                </p>
                            </div>
                        </div>
                        <form class="row" method="GET">
                            @csrf
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="groupmotorik" class="form-label">{{ __('message.group') }}</label>
                                    <select id="groupmotorik" class="form-select select2" name="groupmotorik">
                                        <option hidden disabled>Group Motorik</option>
                                        @foreach ($m_group_motorik as $group)
                                            <option value="{{ $group->pk }}"
                                                {{ Request::input('groupmotorik') == $group->pk ? 'selected' : '' }}>
                                                {{ $group->nm }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="kategorimotorik"
                                        class="form-label">{{ __('message.kategori') }}</label>
                                    <select id="kategorimotorik" class="form-select select2" name="kategorimotorik">
                                        <option hidden disabled>Kategori Motorik</option>
                                        @foreach ($m_kategori_motorik as $kategori)
                                            <option value="{{ $kategori->pk }}"
                                                {{ Request::input('kategorimotorik') == $kategori->pk ? 'selected' : '' }}>
                                                {{ $kategori->nm }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary btn-md mr-2">Search <i
                                                class="fas fa-search pl-1"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex justify-content-end mt-2 mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-primary btn-md">
                                        <i class="fas fa-print h2"></i>
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-secondary btn-md">
                                        <i class="fas fa-file-excel"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table-striped table nowrap" id="myTable" style="width: 100%">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.nmprosedur') }}</th>
                                        <th>Group</th>
                                        <th>{{ __('message.kategori') }}</th>
                                        <th>{{ __('message.bimbingan') }}</th>
                                        <th>{{ __('message.mandiri') }}</th>
                                        <th>Need Approved <br> Bimbingan | Mandiri</th>
                                        <th>View Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residen->motorikTransaction as $tmotorik)
                                        <tr class="text-center">
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $tmotorik->motorik->nm }}</td>
                                            <td>{{ $tmotorik->motorik->motorikGroup->nm }}</td>
                                            <td>{{ $tmotorik->motorik->category->nm }}</td>
                                            <td>{{ $tmotorik->qtybimbingan }}</td>
                                            <td>{{ $tmotorik->qtymandiri }}</td>
                                            <td>
                                                <span
                                                    class="btn {{ $tmotorik->stsbimbingan > 0 ? 'btn-primary' : 'btn-secondary' }} btn-md">{{ $tmotorik->stsbimbingan > 0 ?? $tmotorik->stsbimbingan }}</span>
                                                <span
                                                    class="btn {{ $tmotorik->stsmandiri > 0 ? 'btn-primary' : 'btn-secondary' }} btn-md">{{ $tmotorik->stsmandiri > 0 ?? $tmotorik->stsmandiri }}</span>
                                            </td>
                                            <td>
                                                <span class="btn btn-primary"><i class="fas fa-comment-dots"></i></span>
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
                scrollX: true,
            });
        });
    </script>
@endpush
