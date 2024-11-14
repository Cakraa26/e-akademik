<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">CISOT</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">ct</a>
        </div>
        <ul class="sidebar-menu">
            {{-- General Menu --}}
            <li class="menu-header">{{ __('message.generalmenu') }}</li>
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('dashboard') }}"><i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('message.dashboard') }}</span></a>
            </li>

            @if (session('role') == 2)
                <li class="{{ Request::is('download-file') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('download-file') }}"><i class="fas fa-download"></i>
                        <span>Download File</span></a>
                </li>

                <li class="menu-header">Data</li>
                {{-- Kognitif --}}
                <li class="nav-item dropdown {{ $type_menu === 'kognitif' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-brain"></i><span>{{ __('message.kognitif') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('jadwal-stase*') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ route('jadwal.stase.index') }}">{{ __('message.jdwstase') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.nilaistase') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">UTS</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">UAS</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.rekapnilai') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Afektif --}}
                <li class="nav-item dropdown {{ $type_menu === 'afektif' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-user-check"></i><span>{{ __('message.afektif') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.absensi') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.dftabsensi') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Psikomotorik --}}
                <li class="{{ Request::is('psikomotorik*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('psikomotorik.index') }}"><i class="fas fa-hands"></i>
                        <span>{{ __('message.dtmotorik') }}</span></a>
                </li>

                {{-- Laporan --}}
                <li class="menu-header">
                <li class="menu-header">{{ __('message.record') }}</li>
                </li>

                <li class="{{ Request::is('karya-ilmiah-residen') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('karya-ilmiah.residen.index') }}"><i
                            class="fas fa-file-alt"></i>
                        <span>{{ __('message.karyailmiah') }}</span></a>
                </li>
                <li class="{{ Request::is('laporan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('laporan') }}"><i class="fas fa-chart-bar"></i>
                        <span>{{ __('message.laporan') }}</span></a>
                </li>
            @endif

            @if (session('role') == 1)
                {{-- Setting --}}
                <li class="nav-item dropdown {{ $type_menu === 'setting' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-cog"></i><span>{{ __('message.setting') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('tahun-ajaran*') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ route('tahun-ajaran.index') }}">{{ __('message.thnajaran') }}</a>
                        </li>
                        <li class="{{ Request::is('tingkat-residen*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('tingkat.residen.index') }}">{{ __('message.tingkatresiden') }}</a>
                        </li>
                        <li class="{{ Request::is('stase') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('stase') }}">{{ __('message.harikerja') }}</a>
                        </li>
                        <li class="{{ Request::is('upload-file*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('upload-file') }}">{{ __('message.uploadfile') }}</a>
                        </li>
                    </ul>
                </li>
                {{-- Master Data --}}
                <li class="nav-item dropdown {{ $type_menu === 'master-data' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i><span>Master
                            Data</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('data-dosen*') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ route('data.dosen.index') }}">{{ __('message.datadosen') }}</a>
                        </li>
                        <li class="{{ Request::is('data-mahasiswa*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('data.mahasiswa.index') }}">{{ __('message.datacalonresiden') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.databaseresiden') }}</a>
                        </li>
                        <li class="{{ Request::is('data-stase*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('data.stase.index') }}">{{ __('message.datastase') }}</a>
                        </li>
                        <li class="{{ Request::is('data-kelas*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('data.kelas.index') }}">{{ __('message.datakelas') }}</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-header">{{ __('message.akademik') }}</li>

                {{-- Kognitif --}}
                <li class="nav-item dropdown {{ $type_menu === 'kognitif' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-brain"></i><span>{{ __('message.kognitif') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('jadwal-stase*') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ route('jadwal.stase.index') }}">{{ __('message.jdwstase') }}</a>
                        </li>
                        <li class="{{ Request::is('nilai-stase') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('nilai.stase.index') }}">{{ __('message.nilaistase') }}</a>
                        </li>
                        <li class="{{ Request::is('uts') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('uts.index') }}">UTS</a>
                        </li>
                        <li class="{{ Request::is('uas') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('uas.index') }}">UAS</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.rekapnilai') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Psikomotorik --}}
                <li class="nav-item dropdown {{ $type_menu === 'psikomotorik' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-hands"></i><span>{{ __('message.psikomotorik') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('data-group*') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ route('data.group.index') }}">{{ __('message.grpmotorik') }}</a>
                        </li>
                        <li class="{{ Request::is('kategori-psikomotorik*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('kategori.psikomotorik.index') }}">{{ __('message.ktgmotorik') }}</a>
                        </li>
                        <li class="{{ Request::is('subkategori-psikomotorik*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('subkategori.motorik.index') }}">{{ __('message.subktgmotorik') }}</a>
                        </li>
                        <li class="{{ Request::is('data-psikomotorik*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('data.psikomotorik.index') }}">{{ __('message.dtmotorik') }}</a>
                        </li>
                        <li class="{{ Request::is('monitoring-motorik*') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ route('monitoring.index') }}">{{ __('message.mngmotorik') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Afektif --}}
                <li class="nav-item dropdown {{ $type_menu === 'afektif' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-user-check"></i><span>{{ __('message.afektif') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('blank-page') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.atrjam') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.absensi') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.dftabsensi') }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Karya Ilmiah --}}
                <li class="nav-item dropdown {{ $type_menu === 'karyailmiah' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-file-alt"></i><span>{{ __('message.karyailmiah') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('karya-ilmiah*') ? 'active' : '' }}'>
                            <a class="nav-link"
                                href="{{ route('karya-ilmiah.index') }}">{{ __('message.mstkarya') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link"
                                href="{{ url('blank-page') }}">{{ __('message.residenkarya') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.laporan') }}</a>
                        </li>
                    </ul>
                </li>


                <li class="menu-header">{{ __('message.record') }}</li>
                {{-- Laporan --}}
                <li class="nav-item dropdown {{ $type_menu === 'laporan' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="fas fa-chart-bar"></i><span>{{ __('message.laporan') }}</span></a>
                    <ul class="dropdown-menu">
                        <li class='{{ Request::is('blank-page') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.residen') }}</a>
                        </li>
                        <li class='{{ Request::is('blank-page') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.rekapnilai') }}</a>
                        </li>
                        <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.absensi') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </aside>
</div>
