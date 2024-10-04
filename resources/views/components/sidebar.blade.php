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
            <li class="menu-header">Menu Umum</li>
            <li class="{{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            {{-- Setting --}}
            <li class="{{ Request::is('/setting') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/setting') }}"><i class="fas fa-cog"></i>
                    <span>Setting</span></a>
            </li>

            {{-- Master Data --}}
            <li class="menu-header">Master Data</li>
            <li class="{{ Request::is('data-dosen*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('data.dosen.index') }}"><i class="fas fa-user-tie"></i> <span>Data
                        Dosen</span></a>
            </li>
            <li class="{{ Request::is('data-mahasiswa') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('data.mahasiswa.index') }}"><i class="fas fa-user-plus"></i>
                    <span>Data Calon
                        Residen</span></a>
            </li>
            <li class="{{ Request::is('data-stase*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('data.stase.index') }}"><i class="fas fa-clipboard-list"></i>
                    <span>Data
                        Stase</span></a>
            </li>

            {{-- Data Residen --}}
            <li class="menu-header">Data Residen</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-users"></i> <span>Data
                        Residen</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-brain"></i>
                    <span>Kognitif</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-hand-holding-heart"></i>
                    <span>Afektif</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-hands"></i>
                    <span>Psikomotorik</span></a>
            </li>

            {{-- Laporan --}}
            <li class="menu-header">Laporan</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-file-alt"></i> <span>Karya
                        Ilmiah</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-chart-bar"></i>
                    <span>Laporan - laporan</span></a>
            </li>

            {{-- Data Akademik --}}
            <li class="menu-header">Data Akademik</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-clipboard-check"></i>
                    <span>Absensi</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-folder-open"></i>
                    <span>Nilai</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('blank-page') }}"><i class="fas fa-download"></i> <span>Download
                        File</span></a>
            </li>
        </ul>
    </aside>
</div>
