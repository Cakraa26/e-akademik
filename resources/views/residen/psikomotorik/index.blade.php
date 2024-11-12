@extends('layouts.app')

@section('title', __('message.dtmotorik'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
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
                            <div class="breadcrumb-item">{{ __('message.dtmotorik') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                {{-- <form action="" method="GET">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12 col-md-4">
                            <div class="mb-3">
                                <label for="kategorifk" class="form-label">{{ __('message.ktgmotorik') }}</label>
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
                        <div class="col-12 col-md-4">
                            <div class="mb-3">
                                <label for="kategoriInput" class="form-label">{{ __('message.subktgmotorik') }}</label>
                                <select class="form-select select2" id="subkategorifk" name="subkategorifk">
                                    <option value=""></option>
                                    @foreach ($subkategori as $s)
                                        <option value="{{ $s->pk }}"
                                            {{ Request::get('subkategorifk') == $s->pk ? 'selected' : '' }}>
                                            {{ $s->nm }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mt-n4 mt-md-0">
                            <div class="mb-3">
                                <label>&nbsp;</label>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary mr-2">Filter <i
                                            class="fas fa-sort-amount-up pl-1"></i></button>
                                    <a href="{{ route('data.psikomotorik.index') }}" class="btn btn-secondary">Refresh <i
                                            class="fas fa-sync-alt pl-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> --}}

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.residen') }}</label>
                        <h2 class="section-title2">{{ auth()->user()->nm }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">Semester</label>
                        <h2 class="section-title2">{{ auth()->user()->semester }}</h2>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.tingkat') }}</label>
                        <h2 class="section-title2">{{ auth()->user()->tingkat }}</h2>
                    </div>
                </div>

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

                @foreach ($motorik as $subkategorifk => $data)
                    @if (request('subkategorifk') == null || request('subkategorifk') == $subkategorifk)
                        <div class="card">
                            <div class="card-body">
                                <h2 class="section-title">{{ $data->first()->subkategori->nm }}</h2>
                                <div class="table-responsive">
                                    <table class="table-striped table myTable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>{{ __('message.prosedur') }}</th>
                                                <th>{{ __('message.bimbingan') }}</th>
                                                <th>{{ __('message.mandiri') }}</th>
                                                <th>Status</th>
                                                <th>{{ __('message.aksi') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($data as $m)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $m->nm }}</td>
                                                    <td>{{ $m->t_motorik->first()->qtybimbingan ?? '' }}</td>
                                                    <td>{{ $m->t_motorik->first()->qtymandiri ?? '' }}</td>
                                                    <td>
                                                        @php
                                                            $tmotorik = optional($m->t_motorik->first());
                                                        @endphp
                                                        @if ($tmotorik->stsmandiri === 1 || $tmotorik->stsbimbingan === 1)
                                                            <span class="text-danger">{{ __('message.menunggu') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn p-0 mr-2 text-primary" data-bs-toggle="modal"
                                                            data-bs-target="#uploadModal{{ $m->pk }}">{{ __('message.upload') }}</button>
                                                       
                                                        @foreach ($m->t_motorik as $tmotorik)
                                                        <a href="{{ route('psikomotorik.edit', $tmotorik->pk) }}"
                                                            class="btn p-0 text-secondary {{ Request::is('psikomotorik/' . $tmotorik->pk . '/edit') ? 'active' : '' }}">Detail</a>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </section>

        <!-- Modal Upload -->
        @foreach ($motorik as $subkategorifk => $data)
            @foreach ($data as $m)
                <div class="modal fade" id="uploadModal{{ $m->pk }}" tabindex="-1"
                    aria-labelledby="uploadModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>{{ __('message.upload') }} File - {{ $m->nm }}</h5>
                            </div>
                            <form action="{{ route('psikomotorik.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body mt-n1">
                                    <input type="hidden" name="motorikpk" value="{{ $m->pk }}">
                                    <input type="file" class="form-control" name="fileMotorik">
                                    <div class="row mt-4">
                                        <div class="col-md-2">
                                            <label class="form-label">Status :</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            value="0" {{ old('status') == '0' ? 'checked' : '' }}
                                                            checked>
                                                        <label class="form-check-label">{{ __('message.mandiri') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            value="1" {{ old('status') == '1' ? 'checked' : '' }}>
                                                        <label
                                                            class="form-check-label">{{ __('message.bimbingan') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-n4">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.boostrap4.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('.myTable').DataTable({
                scrollX: true
            });
        });
    </script>
@endpush
