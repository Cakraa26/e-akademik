@extends('layouts.auth')

@section('title', 'OTP')

@push('style')
    <!-- CSS Libraries -->
    <style>
        /* OTP input styles */
        .otp-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .otp-input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }

        .otp-input:focus {
            border-color: #557C56;
        }

        #verificationCode {
            width: 100%;
            margin-top: 15px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }

        #verificationCode:focus {
            border-color: #557C56;
        }

        .resendbtn {
            background: transparent;
            border: none;
            color: #1A5319;
            font-weight: bold;
        }

        .resendbtn.disabled {
            color: #557C56
        }
        .time-up{
            color: #dc3545;
        }
    </style>
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible show fade" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <div class="card card-success">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-lg-11 p-0 mb-2">
                    <div class="px-0 pt-4 pb-0 mb-3">
                        <div class="text-center">
                            <h2 id="heading">Verifikasi OTP</h2>
                            <p>Kode verifikasi telah berhasil dikirim ke WhatsApp Anda. </p>
                        </div>
                        <form id="otpForm" class="mobile-otp" method="POST" action="{{ route('otp.verify.post', $pk) }}">
                            @csrf
                            <div class="otp-container">
                                @for ($i = 0; $i < 4; $i++)
                                    <input type="text" name="otp[]" class="otp-input" pattern="\d" maxlength="1"
                                        {{ $i > 0 ? 'disabled' : '' }}>
                                @endfor
                            </div>


                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" id="verifyMobileOTP" class="btn btn-success">Verifikasi</button>
                            </div>
                            <div id="timer" class="mt-3 text-center"><span id="countdown">01:00</span></div>
                        </form>

                        <form id="resendForm" method="POST" action="{{ route('otp.resend', $pk) }}">
                            @csrf
                            <div class="d-flex justify-content-center align-items-center mb-n3">
                                <p>Tidak mendapat kode OTP<button type="submit" id="resendOTP" class="resendbtn">Kirim
                                        Ulang</button></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var otpInputs = document.querySelectorAll(".otp-input");

            function setupOtpInputListeners(inputs) {
                inputs.forEach(function(input, index) {
                    input.addEventListener("paste", function(ev) {
                        var clip = ev.clipboardData.getData("text").trim();
                        if (!/^\d{6}$/.test(clip)) {
                            ev.preventDefault();
                            return;
                        }

                        var characters = clip.split("");
                        inputs.forEach(function(otpInput, i) {
                            otpInput.value = characters[i] || "";
                        });

                        enableNextBox(inputs[0], 0);
                        inputs[5].removeAttribute("disabled");
                        inputs[5].focus();
                        updateOTPValue(inputs);
                    });

                    input.addEventListener("input", function() {
                        var currentIndex = Array.from(inputs).indexOf(this);
                        var inputValue = this.value.trim();

                        if (!/^\d$/.test(inputValue)) {
                            this.value = "";
                            return;
                        }

                        if (inputValue && currentIndex < 5) {
                            inputs[currentIndex + 1].removeAttribute("disabled");
                            inputs[currentIndex + 1].focus();
                        }

                        if (currentIndex === 4 && inputValue) {
                            inputs[5].removeAttribute("disabled");
                            inputs[5].focus();
                        }

                        updateOTPValue(inputs);
                    });

                    input.addEventListener("keydown", function(ev) {
                        var currentIndex = Array.from(inputs).indexOf(this);

                        if (!this.value && ev.key === "Backspace" && currentIndex > 0) {
                            inputs[currentIndex - 1].focus();
                        }
                    });
                });
            }

            function updateOTPValue(inputs) {
                var otpValue = "";
                inputs.forEach(function(input) {
                    otpValue += input.value;
                });

                if (inputs === otpInputs) {
                    document.getElementById("verificationCode").value = otpValue;
                }
            }

            setupOtpInputListeners(otpInputs);

            document.getElementById("verifyMobileOTP").addEventListener("click", function() {
                var otpValue = document.getElementById("verificationCode").value;
                alert("Submitted OTP: " + otpValue);
            });

            otpInputs[0].focus();
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const resendButton = document.getElementById('resendOTP');
            const countdownElement = document.getElementById('countdown');
            let countdown;

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    if (input.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].disabled = false;
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            function startCountdown(duration) {
                let timer = duration;
                clearInterval(countdown);
                countdown = setInterval(() => {
                    const minutes = parseInt(timer / 60, 10);
                    const seconds = parseInt(timer % 60, 10);

                    const displayMinutes = minutes < 10 ? "0" + minutes : minutes;
                    const displaySeconds = seconds < 10 ? "0" + seconds : seconds;

                    countdownElement.textContent = displayMinutes + ":" + displaySeconds;

                    if (--timer < 0) {
                        clearInterval(countdown);
                        countdownElement.textContent = "Waktu Habis!";
                        countdownElement.classList.add('time-up');
                    }
                }, 1000);
            }

            startCountdown(60);
        });
    </script>
@endpush
