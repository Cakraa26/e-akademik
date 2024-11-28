@extends('layouts.app')

@section('title', __('message.detailmotorik'))

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('psikomotorik.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item">Detail</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('message.psikomotorik') }}</label>
                        <h2 class="section-title2">{{ $tmotorik->motorik->nm }}</h2>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <label class="form-label">{{ __('message.subkategori') }}</label>
                        <h2 class="section-title2">{{ $tmotorik->motorik->subCategory->nm }}</h2>
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
                            <table class="table-striped table myTable" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>{{ __('message.tanggal') }}</th>
                                        <th>Semester</th>
                                        <th>{{ __('message.tingkat') }}</th>
                                        <th>{{ __('message.mandiri') }}/{{ __('message.bimbingan') }}</th>
                                        <th>Status</th>
                                        <th>{{ __('message.ctn') }}</th>
                                        <th>
                                            @if ($motorikTransactionData->contains('stsapproved', 2))
                                                {{ __('message.aksi') }}
                                            @endif
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($motorikTransactionData as $t)
                                        <tr>
                                            <td>
                                                <a href="{{ asset('storage/' . $t->nmfile) }}"
                                                    style="text-decoration: underline;">
                                                    {{ $no++ }}
                                                </a>
                                            </td>
                                            <td>{{ $t->tgl }}</td>
                                            <td>{{ $t->semester }}</td>
                                            <td>{{ $t->tingkat->nm }}</td>
                                            <td>{{ $t->stsbimbingan === 1 ? 'Bimbingan' : ($t->stsmandiri === 1 ? 'Mandiri' : '') }}
                                            </td>
                                            <td>
                                                @if ($t->stsapproved === 1)
                                                    <span class="badge badge-warning">{{ __('message.menunggu') }}</span>
                                                @elseif ($t->stsapproved === 2)
                                                    <span class="badge badge-success">{{ __('message.disetujui') }}</span>
                                                @elseif ($t->stsapproved === 3)
                                                    <span class="badge badge-secondary">{{ __('message.cancel') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $t->ctn }}</td>
                                            <td class="text-nowrap">
                                                @if ($t->stsapproved === 2)
                                                    <button type="button" class="btn p-0 mr-2 text-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#uploadModal{{ $t->pk }}">{{ __('message.upload') }}</button>

                                                    <form action="{{ route('psikomotorik.destroy', $t->pk) }}"
                                                        method="POST" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn text-danger p-0 swal-6">{{ __('message.hapus') }}
                                                        </button>
                                                    </form>
                                                @endif
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
        @foreach ($motorikTransactionData as $t)
            <div class="modal fade" id="uploadModal{{ $t->pk }}" tabindex="-1" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('psikomotorik.upload.detail') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="motorikpk" value="{{ $t->motorikfk }}">
                                <input type="hidden" name="tmotorikdt" value="{{ $t->pk }}">
                                <input type="file" class="form-control" name="fileMotorik">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/dataTables.boostrap4.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('.myTable').DataTable({
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
