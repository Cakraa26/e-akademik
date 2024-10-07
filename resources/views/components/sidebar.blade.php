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
            <li class="{{ Request::is('/setting') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/setting') }}"><i class="fas fa-cog"></i>
                    <span>{{ __('message.setting') }}</span></a>
            </li>

            {{-- Master Data --}}
            <li class="menu-header">Master Data</li>
            <li class="{{ Request::is('data-dosen*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('data.dosen.index') }}"><i class="fas fa-user-tie"></i> <span>
                        {{ __('message.datadosen') }}</span></a>
            </li>
            <li class="{{ Request::is('data-mahasiswa') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('data.mahasiswa.index') }}"><i class="fas fa-user-plus"></i>
                    <span>{{ __('message.datacalonresiden') }}</span></a>
            </li>
            <li class="{{ Request::is('data-stase*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('data.stase.index') }}"><i class="fas fa-clipboard-list"></i>
                    <span>{{ __('message.datastase') }}</span></a>
            </li>

            {{-- Data Residen --}}
            <li class="menu-header">{{ __('message.dataresiden') }}</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-users"></i>
                    <span>{{ __('message.dataresiden') }}</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-brain"></i>
                    <span>{{ __('message.kognitif') }}</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-hand-holding-heart"></i>
                    <span>{{ __('message.afektif') }}</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-hands"></i>
                    <span>{{ __('message.psikomotorik') }}</span></a>
            </li>

            {{-- Laporan --}}
            <li class="menu-header">{{ __('message.laporan') }}</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-file-alt"></i>
                    <span>{{ __('message.karyailmiah') }}</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-chart-bar"></i>
                    <span>{{ __('message.laporan') }}</span></a>
            </li>

            {{-- Data Akademik --}}
            <li class="menu-header">{{ __('message.akademik') }}</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-clipboard-check"></i>
                    <span>{{ __('message.absensi') }}</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-folder-open"></i>
                    <span>{{ __('message.nilai') }}</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-download"></i> <span>Download
                        File</span></a>
            </li>
        </ul>
    </aside>
</div>
