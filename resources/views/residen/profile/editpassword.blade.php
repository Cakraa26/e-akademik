@extends('layouts.auth')

@section('title', __('message.changepassword'))

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-body">
            <form id="form" method="POST" action="{{ route('reset-password') }}" data-parsley-validate autocomplete="off"   >
                @csrf
                <div class="form-group">
                    <label>Old Password</label>
                    <input id="old_password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required data-parsley-required-message="Old password is required">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input id="new_password" type="password"
                        class="form-control @error('new_password') is-invalid @enderror" name="new_password" required
                        data-parsley-required-message="New password is required" data-parsley-notequalto="#old_password"
                        data-parsley-notequalto-message="New password must be different from old password"
                        data-parsley-minlength="8"
                        data-parsley-minlength-message="Password must be at least 8 characters long">
                    @error('new_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input id="password-confirm" type="password"
                        class="form-control @error('confirm-password') is-invalid @enderror" name="confirm-password"
                        required data-parsley-required-message="Confirmation password is required"
                        data-parsley-equalto="#new_password" data-parsley-equalto-message="Passwords must match">
                    @error('confirm-password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block mb-n3">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#form').parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            })
        });
    </script>
@endpush
