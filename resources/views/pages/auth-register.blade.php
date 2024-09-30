@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/input.css') }}">
    <style>
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 53%;
            transform: translateY(-50%);
            cursor: pointer;
            display: none;
            z-index: 10;
        }

        ::-ms-reveal {
            display: none;
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

    <div class="card card-success">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-10 col-lg-11 p-0 mb-2">
                    <div class="px-0 pt-4 pb-0 mb-3">
                        <div class="text-center">
                            <h2 id="heading">Daftar</h2>
                            <p>Isi semua kolom formulir untuk melanjutkan ke langkah berikutnya</p>
                        </div>
                        <form id="msform" action="{{ route('actionRegister') }}" method="POST">
                            @csrf
                            <!-- progressbar -->
                            <ul id="progressbar" class="text-center">
                                <li class="active" id="account"><strong>Account</strong></li>
                                <li id="personal"><strong>Personal</strong></li>
                                <li id="study"><strong>Study</strong></li>
                                <li id="family"><strong>Family</strong></li>
                                {{-- <li id="finish"><strong>Finish</strong></li> --}}
                            </ul>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <br>
                            <fieldset>
                                <div class="form-card">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label class="required">Nama Lengkap</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="nm" name="nm"
                                                    value="{{ old('nm') }}" required
                                                    data-parsley-required-message="Nama Lengkap wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">NIM</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="nim" name="nim"
                                                    value="{{ old('nim') }}" required
                                                    data-parsley-required-message="NIM wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fas fa-address-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Nama Panggilan</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="nickname" name="nickname"
                                                    value="{{ old('nickname') }}" required
                                                    data-parsley-required-message="Nama Panggilan wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-user-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Inisial Residen</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="inisialresiden" name="inisialresiden"
                                                    value="{{ old('inisialresiden') }}" required
                                                    data-parsley-required-message="Inisial Residen wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-id-badge"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">No. KTP</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="ktp" name="ktp"
                                                    value="{{ old('ktp') }}" required
                                                    data-parsley-required-message="No. KTP wajib diisi."
                                                    data-parsley-type="number"
                                                    data-parsley-type-message="No. KTP harus berupa angka valid." />
                                                <div class="input-icon">
                                                    <i class="fa fa-id-card"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Email</label>
                                            <div class="input-group input-group-icon" id="input-group">
                                                <input type="email" id="email" name="email"
                                                    value="{{ old('email') }}" required
                                                    data-parsley-required-message="Email wajib diisi."
                                                    data-parsley-type="email"
                                                    data-parsley-type-message="Format email tidak valid.">
                                                <div class="input-icon">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="required">No. Telepon</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="hp" name="hp"
                                                    value="{{ old('hp') }}" required
                                                    data-parsley-required-message="No. Telepon wajib diisi."
                                                    data-parsley-type="number"
                                                    data-parsley-type-message="No. Telepon harus berupa angka valid." />
                                                <div class="input-icon">
                                                    <i class="fa fa-phone-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Kata Sandi</label>
                                            <div class="input-group input-group-icon">
                                                <input type="password" id="password" name="password"
                                                    value="{{ old('password') }}" required
                                                    data-parsley-required-message="Kata Sandi wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-key"></i>
                                                </div>
                                                <div class="toggle-password" id="togglePassword">
                                                    <i class="fa fa-eye-slash"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Konfirmasi Kata Sandi</label>
                                            <div class="input-group input-group-icon">
                                                <input type="password" id="konfirpass" name="konfirpass"
                                                    value="{{ old('konfirpass') }}" required
                                                    data-parsley-required-message="Konfirmasi Kata Sandi wajib diisi."
                                                    data-parsley-equalto="#password"
                                                    data-parsley-equalto-message="Konfirmasi Kata Sandi tidak cocok." />
                                                <div class="input-icon">
                                                    <i class="fa fa-lock"></i>
                                                </div>
                                                <div class="toggle-password" id="toggleKonfirpass">
                                                    <i class="fa fa-eye-slash"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" name="next" class="next btn btn-success">
                                            Lanjut <i class="fas fa-arrow-right pl-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Tempat Lahir</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="tempatlahir" name="tempatlahir"
                                                    value="{{ old('tempatlahir') }}" required
                                                    data-parsley-required-message="Tempat Lahir wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-map-marker-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Tanggal Lahir</label>
                                            <div class="input-group input-group-icon">
                                                <input type="date" id="tgllahir" name="tgllahir"
                                                    value="{{ old('tgllahir') }}" required
                                                    data-parsley-required-message="Tanggal Lahir belum dipilih." />
                                                <div class="input-icon">
                                                    <i class="fa fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Agama</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="agama" name="agama"
                                                    value="{{ old('agama') }}" required
                                                    data-parsley-required-message="Agama wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-praying-hands"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Gol. Darah</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="goldarah" name="goldarah"
                                                    value="{{ old('goldarah') }}" required
                                                    data-parsley-required-message="Gol. Darah wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-tint"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Alamat KTP</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="alamatktp" name="alamatktp"
                                                    value="{{ old('alamatktp') }}" required
                                                    data-parsley-required-message="Alamat KTP wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fas fa-map-marked-alt"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Alamat Tempat Tinggal</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="alamattinggal" name="alamattinggal"
                                                    value="{{ old('alamattinggal') }}" required
                                                    data-parsley-required-message="Alamat Tempat Tinggal wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-home"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-3 mb-4">
                                            <label class="required">Jumlah Saudara</label>
                                            <div class="input-group input-group-icon">
                                                <input type="number" id="jmlsaudara" name="jmlsaudara"
                                                    value="{{ old('jmlsaudara') }}" required
                                                    data-parsley-required-message="Jumlah Saudara wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-users"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-4">
                                            <label class="required">Anak ke</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="anakke" name="anakke"
                                                    value="{{ old('anakke') }}" required
                                                    data-parsley-required-message="Bagian ini wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-child"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Status Kawin</label>
                                            <div class="input-group">
                                                <select id="statuskawin" name="statuskawin" required
                                                    data-parsley-required-message="Status Kawin belum dipilih.">
                                                    <option value="" disabled selected>Pilih Status Kawin</option>
                                                    <option value="0"
                                                        {{ old('statuskawin') == '0' ? 'selected' : '' }}>Belum Menikah
                                                    </option>
                                                    <option value="1"
                                                        {{ old('statuskawin') == '1' ? 'selected' : '' }}>Sudah Menikah
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" name="previous" class="previous btn btn-secondary mr-2">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                                        </button>
                                        <button type="button" name="next" class="next btn btn-success">
                                            Lanjut <i class="fas fa-arrow-right pl-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Tahun Masuk Orthopaedi</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="thnmasuk" name="thnmasuk"
                                                    value="{{ old('thnmasuk') }}" required
                                                    data-parsley-required-message="Tahun Masuk Orthopaedi wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-calendar-check"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Tahun Lulusan FK</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="thnlulus" name="thnlulus"
                                                    value="{{ old('thnlulus') }}" required
                                                    data-parsley-required-message="Tahun Lulusan FK wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-graduation-cap"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Asal FK</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="asalfk" name="asalfk"
                                                    value="{{ old('asalfk') }}" required
                                                    data-parsley-required-message="Asal FK wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-university"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Status Residen</label>
                                            <div class="input-group">
                                                <select id="statusresiden" name="statusresiden" required
                                                    data-parsley-required-message="Status Residen belum dipilih.">
                                                    <option value="" disabled selected>Pilih Status Residen</option>
                                                    <option value="Mandiri"
                                                        {{ old('statusresiden') == 'Mandiri' ? 'selected' : '' }}>Mandiri
                                                    </option>
                                                    <option value="PNS"
                                                        {{ old('statusresiden') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                                    <option value="Patubel"
                                                        {{ old('statusresiden') == 'Patubel' ? 'selected' : '' }}>Patubel
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" name="previous" class="previous btn btn-secondary mr-2">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                                        </button>
                                        <button type="button" name="next" class="next btn btn-success">
                                            Lanjut <i class="fas fa-arrow-right pl-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <br>
                                    <div id="pasangan" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label class="required">Nama Suami / Istri</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" id="nmpasangan" name="nmpasangan"
                                                        value="{{ old('nmpasangan') }}" required
                                                        data-parsley-required-message="Nama Suami / Istri wajib diisi." />
                                                    <div class="input-icon">
                                                        <i class="fa fa-user-friends"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="required">Alamat Suami / Istri</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" id="alamatpasangan" name="alamatpasangan"
                                                        value="{{ old('alamatpasangan') }}" required
                                                        data-parsley-required-message="Alamat Suami / Istri wajib diisi." />
                                                    <div class="input-icon">
                                                        <i class="fas fa-map-pin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <label class="required">No. Telepon Suami / Istri</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="text" id="hppasangan" name="hppasangan"
                                                        value="{{ old('hppasangan') }}" required
                                                        data-parsley-required-message="No. Telepon Suami / Istri wajib diisi."
                                                        data-parsley-type="number"
                                                        data-parsley-type-message="No. Telepon harus berupa angka valid." />
                                                    <div class="input-icon">
                                                        <i class="fa fa-phone-alt"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="required">Jumlah Anak</label>
                                                <div class="input-group input-group-icon">
                                                    <input type="number" id="anak" name="anak"
                                                        value="{{ old('anak') }}" required
                                                        data-parsley-required-message="Jumlah Anak wajib diisi." />
                                                    <div class="input-icon">
                                                        <i class="fas fa-baby"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Nama Ayah</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="nmayah" name="nmayah"
                                                    value="{{ old('nmayah') }}" required
                                                    data-parsley-required-message="Nama Ayah wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fas fa-male"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Nama Ibu</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="nmibu" name="nmibu"
                                                    value="{{ old('nmibu') }}" required
                                                    data-parsley-required-message="Nama Ibu wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fas fa-female"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Alamat Ayah / Ibu</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="alamatortu" name="alamatortu"
                                                    value="{{ old('alamatortu') }}" required
                                                    data-parsley-required-message="Alamat Ayah / Ibu wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fas fa-home"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Nama Kontak Darurat</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="nmkontak" name="nmkontak"
                                                    value="{{ old('nmkontak') }}" required
                                                    data-parsley-required-message="Nama Kontak Darurat wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-user-shield"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Nomor Kontak Darurat</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="hpkontak" name="hpkontak"
                                                    value="{{ old('hpkontak') }}" required
                                                    data-parsley-required-message="No. Kontak Darurat wajib diisi."
                                                    data-parsley-type="number"
                                                    data-parsley-type-message="No. Kontak Darurat harus berupa angka valid." />
                                                <div class="input-icon">
                                                    <i class="fas fa-phone-volume"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="required">Hubungan Kontak Darurat</label>
                                            <div class="input-group input-group-icon">
                                                <input type="text" id="hubkontak" name="hubkontak"
                                                    value="{{ old('hubkontak') }}" required
                                                    data-parsley-required-message="Hubungan Kontak Darurat wajib diisi." />
                                                <div class="input-icon">
                                                    <i class="fa fa-link"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="datetime-local" id="datemodified" name="datemodified"
                                    value="{{ old('datemodified', now()->format('Y-m-d H:i:s')) }}" hidden>
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" name="previous" class="previous btn btn-secondary mr-2">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            Selesai <i class="fas fa-check pl-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            {{-- <fieldset>
                                <div class="form-card">
                                    <br>
                                    <h2 class="purple-text text-center"><strong>SUKSES !</strong></h2> <br>
                                    <div class="row justify-content-center">
                                        <div class="col-3"> <img src="{{ asset('img/sukses.png') }}" class="fit-image">
                                        </div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5 class="purple-text text-center">Anda Telah Berhasil Daftar.</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/page/password.js') }}"></script>

    <!-- Multi Step Registration -->
    <script>
        $(document).ready(function() {
            var $form = $("#msform");
            var $sections = $form.find("fieldset");
            var current = 0;

            setProgressBar(current);

            function navigateTo(index) {
                var currentSection = $sections.eq(current);
                var nextSection = $sections.eq(index);

                currentSection.hide();
                nextSection.show();

                $("#progressbar li").eq(index).addClass("active");

                current = index;
                setProgressBar(current);

                $(".previous").toggle(index > 0);
                var atTheEnd = index >= $sections.length - 1;
                $(".next").toggle(!atTheEnd);
            }

            $form.on("click", ".previous", function() {
                navigateTo(current - 1);
            });

            $form.on("click", ".next", function() {
                $form.parsley().whenValidate({
                    group: 'block-' + current
                }).done(function() {
                    navigateTo(current + 1);
                });
            });

            $sections.each(function(index, section) {
                $(section).find(':input').attr('data-parsley-group', 'block-' + index);
            });

            function setProgressBar(curStep) {
                var percent = parseFloat(100 / $sections.length) * (curStep + 1);
                percent = percent.toFixed();
                $(".progress-bar").css("width", percent + "%");
            }

            $form.parsley({
                errorClass: 'is-invalid parsley-error',
                successClass: 'is-valid',
                errorsWrapper: '<span class="invalid-feedback"></span>',
                errorTemplate: '<div></div>'
            });

            $sections.first().show();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#statuskawin').change(function() {
                var status = $(this).val();

                if (status == "1") {
                    $('#pasangan').show();
                } else {
                    $('#pasangan').hide();
                }
            });
        });
    </script>
@endpush
