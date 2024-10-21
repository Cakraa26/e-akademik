<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">E-Akademik</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">e-ak</a>
        </div>
        <ul class="sidebar-menu">
            {{-- General Menu --}}
            <li class="menu-header">{{ __('message.generalmenu') }}</li>
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-tachometer-alt"></i>
                    <span>{{ __('message.dashboard') }}</span></a>
            </li>

            {{-- Setting --}}
            <li class="nav-item dropdown {{ $type_menu === 'setting' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-cog"></i><span>{{ __('message.setting') }}</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('tahun-ajaran*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('tahun-ajaran.index') }}">{{ __('message.thnajaran') }}</a>
                    </li>
                    <li class="{{ Request::is('tingkat-residen*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tingkat.residen.index') }}">{{ __('message.tingkatresiden') }}</a>
                    </li>
                    <li class="{{ Request::is('stase') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('stase') }}">Stase</a>
                    </li>
                    <li class="{{ Request::is('rs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('rs') }}">{{ __('message.rs') }}</a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Data</li>
            {{-- Master Data --}}
            <li class="nav-item dropdown {{ $type_menu === 'master-data' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-database"></i><span>Master
                        Data</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('data-dosen*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('data.dosen.index') }}">{{ __('message.datadosen') }}</a>
                    </li>
                    <li class="{{ Request::is('data-mahasiswa*') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('data.mahasiswa.index') }}">{{ __('message.datacalonresiden') }}</a>
                    </li>
                    <li class="{{ Request::is('data-stase*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data.stase.index') }}">{{ __('message.datastase') }}</a>
                    </li>
                </ul>
            </li>

            {{-- Kognitif --}}
            <li class="nav-item dropdown {{ $type_menu === 'kognitif' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-brain"></i><span>{{ __('message.kognitif') }}</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('blank-page') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.jdwstase') }}</a>
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

            {{-- Psikomotorik --}}
            <li class="nav-item dropdown {{ $type_menu === 'psikomotorik' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-hands"></i><span>{{ __('message.psikomotorik') }}</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('data-group*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('data.group.index') }}">{{ __('message.grpmotorik') }}</a>
                    </li>
                    <li class="{{ Request::is('kategori-psikomotorik*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kategori.psikomotorik.index') }}">{{ __('message.ktgmotorik') }}</a>
                    </li>
                    <li class="{{ Request::is('subkategori-psikomotorik*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('subkategori.motorik.index') }}">{{ __('message.subktgmotorik') }}</a>
                    </li>
                    <li class="{{ Request::is('data-psikomotorik*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('data.psikomotorik.index') }}">{{ __('message.dtmotorik') }}</a>
                    </li>
                    <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.mngmotorik') }}</a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">{{ __('message.record') }}</li>
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
                    <li class='{{ Request::is('blank-page') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.mstkarya') }}</a>
                    </li>
                    <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.residenkarya') }}</a>
                    </li>
                    <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('blank-page') }}">{{ __('message.laporan') }}</a>
                    </li>
                </ul>
            </li>

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
        </ul>
    </aside>
</div>
