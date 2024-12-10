<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        @if (session('role') == 2)
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                    class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">{{ __('message.notif') }}</div>
                    <div class="dropdown-list-content dropdown-list-icons">
                        @foreach ($notifikasi as $notif)
                            <a href="{{ route('notifikasi') }}" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-icon bg-secondary text-dark">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    {{ $notif->body }}
                                    <div class="time text-primary">
                                        {{ date('d F Y H:i', strtotime($notif->dateadded)) }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="{{ route('notifikasi') }}">{{ __('message.viewall') }} <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        @endif
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if (app()->getLocale() == 'id')
                    <img alt="image" src="{{ asset('img/flag/id.png') }}">
                    <div class="d-sm-none d-lg-inline-block">&nbsp;</div>
                @else
                    <img alt="image" src="{{ asset('img/flag/en.png') }}">
                    <div class="d-sm-none d-lg-inline-block">&nbsp;</div>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="/locale/id">
                    <img src="{{ asset('img/flag/id.png') }}" alt="Bahasa Indonesia"
                        style="width: 20px; margin-right: 5px;"> Indonesia
                </a>
                <a class="dropdown-item" href="/locale/en">
                    <img src="{{ asset('img/flag/en.png') }}" alt="English" style="width: 20px; margin-right: 5px;">
                    English
                </a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ explode(' ', auth()->user()->nm)[2] ?? '' }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ auth()->user()->nm }}</div>
                @if (session('role') == 2)
                    <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>
                    <a href="{{ route('edit.password') }}" class="dropdown-item has-icon">
                        <i class="fas fa-key"></i> {{ __('message.changepassword') }}
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); if(confirm('{{ __('message.konfirm') }}')) { document.getElementById('logout-form').submit(); }">
                    <i class="fas fa-sign-out-alt"></i>{{ __('message.logout') }}
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
