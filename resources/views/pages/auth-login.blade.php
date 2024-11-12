@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('css/input.css') }}">
@endpush

@section('main')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible show fade" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible show fade" role="alert">
            {{ session('gagal') }}
            <button class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card card-primary">
        <div class="text-center pt-4 mb-n3">
            <h2 id="heading">Masuk</h2>
            <p>Lengkapi data untuk masuk ke akun Anda</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login.post') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="phone">No. Telepon</label>
                    <div class="input-group input-group-icon">
                        <input type="text" name="username" id="username" />
                        <div class="input-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                    </div>
                    <div class="input-group input-group-icon">
                        <input type="password" name="password" id="password" />
                        <div class="input-icon">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                    <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                    </div>
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block" tabindex="4">
                        Masuk
                    </button>
                    {{-- <a href="{{ route('dashboard') }}" class="btn btn-success btn-block">Masuk</a> --}}
                </div>
            </form>
            <div class="text-muted mt-3 text-center">
                Belum punya akun? <a href="auth-register">Daftar</a>
            </div>
        </div>
    </div>
@endsection

