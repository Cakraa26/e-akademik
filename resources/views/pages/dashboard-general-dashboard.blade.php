@extends('layouts.app')

@section('title', __('message.dashboard'))

@push('style')
    <!-- CSS Libraries -->
    <style>
        .l-bg-blue-dark {
            background: linear-gradient(to right, #373b44, #4286f4) !important;
            color: #fff;
        }

        .l-bg-green-dark {
            background: linear-gradient(to right, #0a504a, #38ef7d) !important;
            color: #fff;
        }

        .l-bg-orange-dark {
            background: linear-gradient(to right, #a86008, #ffba56) !important;
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
            </div>
            <div class="row">
                @if (session('role') == 1)
                    <div class="col-xl-4 col-lg-6">
                        <div class="card l-bg-blue-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-eye"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">{{ __('message.visitor') }}</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-12">
                                        <h2 class="d-flex align-items-center mb-0">
                                            30
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-xl-4 col-lg-6">
                    <div class="card l-bg-green-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-user-md"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">{{ __('message.registerresiden') }}</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-12">
                                    <h2 class="d-flex align-items-center mb-0">
                                        33
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="card l-bg-orange-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">{{ __('message.residenaktif') }}</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-12">
                                    <h2 class="d-flex align-items-center mb-0">
                                        570
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-center text-dashboard">
                    <div class="mb-3">
                        <img src="{{ asset('img/logo.png') }}" alt="" width="100">
                    </div>
                    <h2>CISOT</h2>
                    <h4>{{ __('message.fkunud') }}</h4>
                    <h5>{{ __('message.prodi') }}</h5>
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
