@extends('layouts.app')

@section('title', __('message.detailmng'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        i.fa-solid.fa-angle-right {
            color: #c0c2c3;
            margin: 0 8px;
        }
    </style>
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $residen->nm }}</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('monitoring.index') }}">{{ __('message.mngmotorikpendek') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.detail') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row col-md-6">
                    <h2 class="section-title">Semester : {{ $residen->semester }} <i class="fa-solid fa-angle-right"></i>
                        {{ __('message.tingkat') }} : {{ $residen->tingkat->kd }}</h2>
                </div>

                <div class="d-flex justify-content-end align-items-center mb-3">
                    <a class="btn btn-dark mr-1" href="{{ route('monitoring.index') }}">
                        <i class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                    <button type="button" class="btn btn-primary mr-1" id="btnCetak">{{ __('message.cetak') }}<i
                            class='fas fa-print pl-2'></i></button>
                    <button type="button" class="btn btn-success" id="btnCetak">Excel<i
                            class="fas fa-file-excel pl-2"></i></button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade" role="alert">
                        <strong>{{ __('message.success') }}!</strong> {{ session('success') }}
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="" method="GET">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-4 mb-3 pr-md-0">
                                    <label for="groupfk" class="form-label">{{ __('message.group') }}</label>
                                    <select class="form-control select2" name="groupfk" id="groupfk">
                                        <option value=""></option>
                                        @foreach ($group as $g)
                                            <option value="{{ $g->pk }}"
                                                {{ Request::get('groupfk') == $g->pk ? 'selected' : '' }}>
                                                {{ $g->nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8 col-md-4 mb-3 pr-0">
                                    <label for="kategorifk" class="form-label">{{ __('message.kategori') }}</label>
                                    <select class="form-control select2" name="kategorifk" id="kategorifk">
                                        <option value=""></option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->pk }}"
                                                {{ Request::get('kategorifk') == $k->pk ? 'selected' : '' }}>
                                                {{ $k->nm }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 col-md-4 mb-3">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-danger mr-1"><i
                                                class="fas fa-search"></i></button>
                                        <a href="{{ route('monitoring.detail', $residen->pk) }}" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table-striped table" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>{{ __('message.nmprosedur') }}</th>
                                        <th>{{ __('message.group') }}</th>
                                        <th>{{ __('message.kategori') }}</th>
                                        <th>{{ __('message.bimbingan') }}</th>
                                        <th>{{ __('message.mandiri') }}</th>
                                        <th class="text-center" style="width: 25%;">
                                            {{ __('message.approve') }}
                                            <br>
                                            {{ __('message.bimbingan') }} | {{ __('message.mandiri') }}
                                        </th>
                                        <th>{{ __('message.viewdetail') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($tmotorik as $t)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $t->motorik->nm }}</td>
                                            <td>{{ $t->motorik->motorikGroup->nm }}</td>
                                            <td>{{ $t->motorik->category->nm }}</td>
                                            <td>{{ $t->qtybimbingan }}</td>
                                            <td>{{ $t->qtymandiri }}</td>
                                            <td>
                                                <div class="text-center">
                                                    <a href="{{ route('monitoring.approve', ['pk' => $t->pk, 'residenfk' => $t->residenfk]) }}"
                                                        class="btn btn-secondary mr-2">
                                                        {{ $t->motorikData->where('stsbimbingan', 1)->where('stsapproved', 1)->sum('jmlfile') }}
                                                    </a>
                                                    <i class="fas fa-ellipsis-v"></i>
                                                    <a href="{{ route('monitoring.approve', ['pk' => $t->pk, 'residenfk' => $t->residenfk]) }}"
                                                        class="btn btn-secondary ml-2">
                                                        {{ $t->motorikData->where('stsmandiri', 1)->where('stsapproved', 1)->sum('jmlfile') }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-dark btn-table" data-bs-toggle="modal"
                                                    data-bs-target="#ViewDetail{{ $t->pk }}"><i
                                                        class='fas fa-eye'></i></button>
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

        {{-- Modal Detail --}}
        @foreach ($tmotorik as $t)
            <div class="modal fade" id="ViewDetail{{ $t->pk }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="table-responsive nowrap">
                                <table class="table-striped table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>{{ __('message.tglupload') }}</th>
                                            <th>File</th>
                                            <th>{{ __('message.ctn') }}</th>
                                            <th>Status</th>
                                            <th>{{ __('message.aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($t->motorikData as $detail)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $detail->tgl }}</td>
                                                <td>{{ $detail->nmfile }}</td>
                                                <td>{{ $detail->ctn }}</td>
                                                <td>{{ $detail->stsbimbingan === 1 ? 'Mandiri' : 'Bimbingan' }}</td>
                                                <td>
                                                    @if ($detail->stsapproved === 1)
                                                        {{ __('message.approve') }}
                                                    @elseif($detail->stsapproved === 2)
                                                        {{ __('message.disetujui') }}
                                                    @elseif($detail->stsapproved === 3)
                                                        {{ __('message.cancel') }}
                                                    @else
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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
    </div>
@endsection


@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.boostrap4.js') }}"></script>
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
