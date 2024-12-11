@extends('layouts.app')

@section('title', __('message.dashboard'))

@push('style')
    <!-- CSS Libraries -->
    <style>
        .l-bg-green-dark {
            background: linear-gradient(to right, #0a504a, #38ef7d) !important;
            color: #fff;
        }

        .l-bg-orange-dark {
            background: linear-gradient(to right, #a86008, #ffba56) !important;
            color: #fff;
        }

        .l-bg-red-dark {
            background: linear-gradient(to right, #8b0000, #ff6347) !important;
            color: #fff;
        }

        .card .card-statistic-3 .card-icon-large .fas {
            font-size: 110px;
        }

        .card .card-statistic-3 .card-icon {
            text-align: center;
            line-height: 50px;
            margin-left: 15px;
            color: #000;
            position: absolute;
            right: 10px;
            top: 20px;
            opacity: 0.1;
        }

        .text-dashboard h4,
        .text-dashboard h5 {
            font-weight: 400;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('message.dashboard') }}</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item">{{ $currentMonthName }}</div>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6">
                    <div class="card l-bg-green-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-check-circle"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">{{ __('message.absensi') }}</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-12">
                                    <h2 class="d-flex align-items-center mb-0">
                                        {{ $kehadiran }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="card l-bg-orange-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-clock"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">{{ __('message.terlambat') }}</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-12">
                                    <h2 class="d-flex align-items-center mb-0">
                                        {{ $terlambat }} {{ __('message.menit') }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="card l-bg-red-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-times-circle"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">{{ __('message.alpa') }}</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-12">
                                    <h2 class="d-flex align-items-center mb-0">
                                        {{ $alpa }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-success mb-3">{{ __('message.pengumuman') }} <i class="fa-solid fa-bullhorn ml-1"></i>
                    </p>
                    <hr>
                    @foreach ($pengumuman as $p)
                        <h6 class="text-success">{{ $p->judul }}</h6>
                        <h6 style="font-weight: 300; line-height: 1.5;">{{ $p->catatan }}</h6>
                        <hr>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Page Specific JS File -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif
@endpush
