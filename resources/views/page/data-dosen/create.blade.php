@extends('layouts.app')

@section('title', 'Tambah Dosen')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                            <div class="breadcrumb-item">Tambah Data Dosen</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Nama</label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">NIP</label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-4">
                                            <label class="required">Pangkat</label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label class="required">Divisi</label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Alamat</label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mb-4">
                                            <label class="required">No. Telepon</label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <label class="required">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Password</label>
                                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}"
                                                required data-parsley-required-message="NIM wajib diisi." />
                                        </div>
                                    </div>
                                    <input type="datetime-local" class="form-control" id="dateadded" name="dateadded"
                                        value="{{ old('dateadded', now()->format('Y-m-d\TH:i')) }}" hidden>
                                    <input type="datetime-local" class="form-control" id="datemodified" name="datemodified"
                                        value="{{ old('datemodified', now()->format('Y-m-d\TH:i')) }}" hidden>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="button" class="btn btn-dark mr-2">
                                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                Simpan <i class="fas fa-save pl-1"></i>
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

    <!-- Page Specific JS File -->
@endpush
