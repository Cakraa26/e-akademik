@extends('layouts.app')

@section('title', __('message.karyailmiah'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
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
                            <div class="breadcrumb-item">{{ __('message.karyailmiah') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
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

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table nowrap" id="myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>{{ __('message.nama') }}</th>
                                        <th>Status</th>
                                        <th>{{ __('message.ctn') }}</th>
                                        <th>{{ __('message.aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($data as $k)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $k->nm }}</td>
                                            <td>
                                                @if ($k->stssudah === 0)
                                                    <span></span>
                                                @elseif ($k->stssudah === 1)
                                                    <span class="badge badge-warning">{{ __('message.pending') }}</span>
                                                @elseif ($k->stssudah === 2)
                                                    <span class="badge badge-success">{{ __('message.selesai') }}</span>
                                                @elseif ($k->stssudah === 3)
                                                    <span class="badge badge-danger">{{ __('message.cancel') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $k->ctnfile }}</td>
                                            <td>
                                                <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $k->karyailmiahpk }}"><i
                                                        class="fa-solid fa-upload"></i></button>
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

        <!-- Modal Upload -->
        @foreach ($data as $k)
            <div class="modal fade" id="uploadModal{{ $k->karyailmiahpk }}" tabindex="-1"
                aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>{{ __('message.upload') }} File - {{ $k->nm }}</h5>
                        </div>
                        <form action="{{ route('karya-ilmiah.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body mt-n2">
                                <input type="hidden" name="karyailmiahpk" value="{{ $k->karyailmiahpk }}">
                                <input type="file" class="form-control" name="karyaIlmiah">
                            </div>
                            <div class="modal-footer mt-n3">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('message.cancel') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('message.upload') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.boostrap4.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                scrollX: true
            });
        });
    </script>
@endpush
