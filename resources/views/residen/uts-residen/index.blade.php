@extends('layouts.app')

@section('title', 'UTS')

@push('style')
    <!-- CSS Libraries -->
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
                            <div class="breadcrumb-item">UTS</div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="section-body">
                <form action="" method="GET">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-8 col-md-3 mb-3 pr-0">
                            <select class="form-control select2" name="thnajaranfk" id="thnajaranfk">
                                @foreach ($thnajaran as $t)
                                    <option value="{{ $t->pk }}"
                                        {{ Request::get('thnajaranfk') == $t->pk || (!Request::get('thnajaranfk') && $t->aktif == 1) ? 'selected' : '' }}>
                                        {{ $t->nm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3 col-md-2">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-danger mr-1"><i class="fas fa-search"></i></button>
                                <a href="{{ route('uts.residen.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-center align-items-center" style="height: 30vh;">
                    <div class="text-center">
                        @if ($kelas)
                            <p class="text-dark">{{ $selectTahunAjaran->nm }}</p>
                            @if ($kelas->status_uts != null)
                                {{ $kelas->status_uts }}
                            @else
                                <h3 class="text-success mt-n2">{{ __('message.novalue') }}</h3>
                            @endif
                        @else
                            <h5>{{ __('message.nodata') }}</h5>
                        @endif
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
