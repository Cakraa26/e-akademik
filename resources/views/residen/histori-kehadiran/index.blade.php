@extends('layouts.app')

@section('title', __('message.historikehadiran'))

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <ul class="nav nav-pills">
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a
                                    href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                            <div class="breadcrumb-item">{{ __('message.historikehadiran') }}</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <form action="" method="GET">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-6 col-md-3 pr-md-0">
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ Request::get('start_date') ?: date('Y-m-d', strtotime('first day of this month')) }}">
                        </div>
                        <div class="col-6 col-md-3 mb-3 mb-md-0 pr-md-0">
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ Request::get('end_date') ?: date('Y-m-d', strtotime('last day of this month')) }}">
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-danger mr-1"><i class="fas fa-search"></i></button>
                                <a href="{{ route('histori.kehadiran.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row my-4 mt-md-5">
                    <div class="col-12 col-md-4">
                        <div class="card card-success">
                            <div class="card-body text-center">
                                <p class="mt-n1">{{ __('message.kehadiran') }}</p>
                                <h2 class="section-title2 mt-n1 mb-n1">{{ $kehadiran }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-secondary">
                            <div class="card-body text-center">
                                <p class="mt-n1">{{ __('message.terlambat') }}</p>
                                <h2 class="section-title2 mt-n1 mb-n1">{{ $terlambat }} menit</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card card-danger">
                            <div class="card-body text-center">
                                <p class="mt-n1">{{ __('message.alpa') }}</p>
                                <h2 class="section-title2 mt-n1 mb-n1">{{ $alpa }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($data->isNotEmpty())
                    @foreach ($data as $d)
                        <div class="row mb-n3">
                            <div class="col-12">
                                <div class="card text-dark">
                                    <div class="card-body">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col-10 d-flex align-items-center mb-2 mb-md-0">
                                                <i class="fas fa-calendar mr-3"></i>
                                                <span>{{ date('l', strtotime($d->check_in)) }},
                                                    {{ date('d F Y', strtotime($d->check_in)) }}</span>
                                            </div>
                                            <div class="col-auto text-center flex-fill">
                                                <p class="text-success mb-0">In</p>
                                                <span>{{ date('H:i', strtotime($d->check_in)) }}</span>
                                            </div>
                                            <div class="col-auto text-center flex-fill">
                                                <p class="text-danger mb-0">Out</p>
                                                <span>{{ date('H:i', strtotime($d->check_out)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 class="text-center">{{ __('message.nohistorikehadiran') }}</h5>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
