@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        #heading {
            text-transform: uppercase;
            color: #387F39;
            font-weight: normal;
        }

        #msform {
            position: relative;
            margin-top: 20px;
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0.5rem;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            position: relative;
        }

        #msform fieldset:not(:first-of-type) {
            display: none;
        }

        #msform .action-button {
            width: 120px;
            background: #387F39;
            color: white;
            border: 0 none;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 0px 10px 5px;
            float: right;
            border-radius: 5px;
        }

        #msform .action-button:hover,
        #msform .action-button:focus {
            background-color: #2f6b30;
        }

        #msform .action-button-previous {
            width: 120px;
            background: #616161;
            color: white;
            border: 0 none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px 10px 0px;
            float: right
        }

        #msform .action-button-previous:hover,
        #msform .action-button-previous:focus {
            background-color: #000000
        }

        .card {
            z-index: 0;
            border: none;
            position: relative
        }

        .fs-title {
            font-size: 25px;
            color: #387F39;
            margin-bottom: 15px;
            font-weight: normal;
            text-align: left
        }

        .purple-text {
            color: #387F39;
            font-weight: normal
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: lightgrey;
            padding-left: 0px;
        }

        #progressbar .active {
            color: #387F39
        }

        #progressbar li {
            list-style-type: none;
            font-size: 15px;
            width: 20%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #account:before {
            font-family: FontAwesome;
            content: "\f13e"
        }

        #progressbar #personal:before {
            font-family: FontAwesome;
            content: "\f007"
        }

        #progressbar #payment:before {
            font-family: FontAwesome;
            content: "\f030"
        }

        #progressbar #confirm:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            color: #ffffff;
            background: lightgray;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            padding: 2px;
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: lightgray;
            position: absolute;
            left: 0;
            top: 25px;
            z-index: -1
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #387F39
        }

        .progress {
            height: 20px
        }

        .progress-bar {
            background-color: #387F39
        }

        .fit-image {
            width: 100%;
            object-fit: cover
        }
    </style>
@endpush

@section('main')
    <div class="card card-primary">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-10 col-lg-11 p-0 mb-2">
                    <div class="px-0 pt-4 pb-0 mb-3">
                        <div class="text-center">
                            <h2 id="heading">Daftar</h2>
                            <p>Isi semua kolom formulir untuk melanjutkan ke langkah berikutnya</p>
                        </div>
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar" class="text-center">
                                <li class="active" id="account"><strong>Account</strong></li>
                                <li id="personal"><strong>Personal</strong></li>
                                <li id="payment"><strong>Image</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div> <br> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="required">Nama Lengkap</label>
                                            <input class="form-control" type="text" name="" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="required">Nama Panggilan</label>
                                            <input class="form-control" type="text" name="uname" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="required">Inisial Residen</label>
                                            <input class="form-control" type="text" name="pwd" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="required">No. KTP</label>
                                            <input class="form-control" type="text" name="cpwd" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="required">Email</label>
                                            <input class="form-control" type="text" name="cpwd" id="email"
                                                onkeyup="validate()" />
                                            <span id="email-emoji"
                                                style="position: absolute; right: 30px; top: 70%; transform: translateY(-50%);"></span>
                                            <span id="text"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="required">No. Telepon</label>
                                            <input class="form-control" type="text" name="pwd" />
                                        </div>
                                    </div>
                                </div>
                                <button type="button" name="next" class="next action-button">
                                    Selanjutnya <i class="fas fa-angle-double-right"></i>
                                </button>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="required">No. Telepon</label>
                                            <input class="form-control" type="text" name="pwd" />
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="required">Alamat KTP</label>
                                            <input class="form-control" type="text" name="pwd" />
                                        </div>
                                    </div>
                                </div>
                                <button type="button" name="next" class="next action-button">
                                    Selanjutnya <i class="fas fa-angle-double-right"></i>
                                </button>
                                <button type="button" name="previous" class="previous action-button-previous">
                                    <i class="fas fa-angle-double-left"></i> Sebelumnya
                                </button>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Image Upload:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 3 - 4</h2>
                                        </div>
                                    </div> <label class="fieldlabels">Upload Your Photo:</label> <input type="file"
                                        name="pic" accept="image/*"> <label class="fieldlabels">Upload Signature
                                        Photo:</label> <input type="file" name="pic" accept="image/*">
                                </div> <input type="button" name="next" class="next action-button" value="Submit" />
                                <input type="button" name="previous" class="previous action-button-previous"
                                    value="Previous" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Finish:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 4 - 4</h2>
                                        </div>
                                    </div> <br><br>
                                    <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                                    <div class="row justify-content-center">
                                        <div class="col-3"> <img src="img.png" class="fit-image"> </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5 class="purple-text text-center">You Have Successfully Signed Up</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {

            var current_fs, next_fs, previous_fs;
            var opacity;
            var current = 1;
            var steps = $("fieldset").length;

            setProgressBar(current);

            $(".next").click(function() {

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                next_fs.show();
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 500
                });
                setProgressBar(++current);
            });

            $(".previous").click(function() {

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                previous_fs.show();

                current_fs.animate({
                    opacity: 0
                }, {
                    step: function(now) {
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        previous_fs.css({
                            'opacity': opacity
                        });
                    },
                    duration: 500
                });
                setProgressBar(--current);
            });

            function setProgressBar(curStep) {
                var percent = parseFloat(100 / steps) * curStep;
                percent = percent.toFixed();
                $(".progress-bar")
                    .css("width", percent + "%")
            }

            $(".submit").click(function() {
                return false;
            })

        });
    </script>
    <script>
        function validate() {
            let msForm = document.getElementById('msform');
            let emailInput = document.getElementById('email');
            let email = emailInput.value;
            let emailEmoji = document.getElementById('email-emoji');
            let text = document.getElementById('text');
            let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

            if (email.match(pattern)) {
                emailEmoji.innerHTML = '<img src="{{ asset('img/check.png') }}" width="18" height="18"">';
                msForm.classList.add('valid');
                msForm.classList.remove('invalid');
                text.innerHTML = "";
                text.style.color = "#A2CA71";
                emailInput.style.border = "1px solid #A2CA71";
            } else {
                emailEmoji.innerHTML = '';
                msForm.classList.remove('valid');
                msForm.classList.add('invalid');
                text.innerHTML = "Alamat email tidak valid.";
                text.style.color = "#fc544b";
                emailInput.style.border = "1px solid #fc544b";
            }
            if (email == "") {
                emailEmoji.innerHTML = '';
                msForm.classList.remove('valid');
                msForm.classList.remove('invalid');
                text.innerHTML = "";
                emailInput.style.border = "";
            }
        }
    </script>
@endpush
