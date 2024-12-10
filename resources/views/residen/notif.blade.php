@extends('layouts.app')

@section('title', __('message.notif'))

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('message.dashboard') }}</a></div>
                    <div class="breadcrumb-item">{{ __('message.notif') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="activities">
                            @foreach ($notifikasi as $notif)
                                <div class="activity">
                                    <div class="activity-icon bg-success shadow-primary text-warning">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span class="text-job text-primary">{{ date('d F Y H:i' , strtotime($notif->dateadded)) }}</span>
                                            <span class="bullet"></span>
                                            <a class="text-job" href="#">{{ $notif->title }}</a>
                                        </div>
                                        <p class="text-dark">{{ $notif->body }}</p>
                                    </div>
                                </div>
                            @endforeach
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
