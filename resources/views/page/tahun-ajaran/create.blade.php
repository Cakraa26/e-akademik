@extends('layouts.app')

@section('title', __('message.tambahtahunajaran'))

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
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('tahun-ajaran.index') }}">{{ __('message.thnajaran') }}</a>
                            </div>
                            <div class="breadcrumb-item">{{ __('message.tambah') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

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
            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="form" action="{{ route('tahun-ajaran.store') }}" method="POST"
                                    data-parsley-validate>
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-4 align-items-center">
                                                <label for="nama"
                                                    class="col-sm-4">{{ __('message.namatahun') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nm" id="nm"
                                                        value="{{ old('nm') }}" required
                                                        data-parsley-required-message="{{ __('message.nmrequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- table bulan 1-3 --}}
                                        <div class="col-md-5">
                                            <div>
                                                <div class="mb-4 align-items-center">
                                                    <label for="nama"
                                                        class="col-sm-3">{{ __('message.bulan1') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="month" placeholder="bulan 1" class="form-control"
                                                            name="bulan1" id="nm" value="{{ old('bulan1') }}"
                                                            required
                                                            data-parsley-required-message="{{ __('message.bln1required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="mb-4 align-items-center">
                                                    <label for="nama"
                                                        class="col-sm-3">{{ __('message.bulan2') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="month" placeholder="bulan 2" class="form-control"
                                                            name="bulan2" id="nm" value="{{ old('bulan2') }}"
                                                            required
                                                            data-parsley-required-message="{{ __('message.bln1required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="mb-4 align-items-center">
                                                    <label for="nama"
                                                        class="col-sm-3">{{ __('message.bulan3') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="month" placeholder="bulan 3" class="form-control"
                                                            name="bulan3" id="nm" value="{{ old('bulan3') }}"
                                                            required
                                                            data-parsley-required-message="{{ __('message.bln3required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- table bulan 4-6 --}}
                                        <div class="col-md-5">
                                            <div>
                                                <div class="mb-4 align-items-center">
                                                    <label for="nama"
                                                        class="col-sm-3">{{ __('message.bulan4') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="month" placeholder="bulan 4" class="form-control"
                                                            name="bulan4" id="nm" value="{{ old('bulan4') }}"
                                                            required
                                                            data-parsley-required-message="{{ __('message.bln4required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="mb-4 align-items-center">
                                                    <label for="nama"
                                                        class="col-sm-3">{{ __('message.bulan5') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="month" placeholder="bulan 5" class="form-control"
                                                            name="bulan5" id="nm" value="{{ old('bulan5') }}"
                                                            required
                                                            data-parsley-required-message="{{ __('message.bln5required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="mb-4 align-items-center">
                                                    <label for="nama"
                                                        class="col-sm-3">{{ __('message.bulan6') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="month" placeholder="bulan 6" class="form-control"
                                                            name="bulan6" id="nm" value="{{ old('bulan6') }}"
                                                            required
                                                            data-parsley-required-message="{{ __('message.bln6required') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-4 align-items-center">
                                                <label for="nama"
                                                    class="col-sm-6">{{ __('message.kepalaprogram') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nmdekan" id="nm"
                                                        value="{{ old('nmdekan') }}" required
                                                        data-parsley-required-message="{{ __('message.kepalaprogramrequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="mb-4 align-items-center">
                                                <label for="nama"
                                                    class="col-sm-6">{{ __('message.nip') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="nip" id="nm"
                                                        value="{{ old('nip') }}" required
                                                        data-parsley-required-message="{{ __('message.niprequired') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 ml-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="status"
                                                    name="aktif" value="1"
                                                    {{ old('aktif') == '1' ? 'checked' : '' }} checked>
                                                <label class="form-check-label"
                                                    for="status">{{ __('message.thnaktif') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="datemodified"
                                        name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a class="btn btn-dark load-btn mr-2"
                                                href="{{ route('tahun-ajaran.index') }}"> <i
                                                    class="fas fa-arrow-left mr-1"></i> {{ __('message.kembali') }}</a>
                                            <button type="submit" class="btn btn-primary load-btn">
                                                {{ __('message.simpan') }} <i class="fas fa-save pl-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
