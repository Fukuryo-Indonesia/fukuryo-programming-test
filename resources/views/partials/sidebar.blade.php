<aside class="navbar navbar-vertical navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand">
            <a href="{{ url('') }}">
                <img src="{{ asset('assets/image/fukuryo_favi_fix_0712.png') }}" width="110" height="32"
                    alt="Fukuryo" class="navbar-brand-image"> <span class="h3">{{ config('app.name') }}</span>
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item d-none d-lg-flex me-3">
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset('assets/vendor/tabler/img/avatars/hacker.png') }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>
                            Administrator
                        </div>
                        <div class="mt-1 small text-muted">Super Admin</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="collapse navbar-collapse mx-3 px-3" id="sidebar-menu">

            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link  show" href="{{ url('') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('masters/categories*') ? 'active' : '' }}">
                    <a class="nav-link  show" href="{{ url('') }}/masters/categories">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-bookmarks">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 10v11l-5 -3l-5 3v-11a3 3 0 0 1 3 -3h4a3 3 0 0 1 3 3z" />
                                <path d="M11 3h5a3 3 0 0 1 3 3v11" />
                            </svg>
                        </span>
                        <span class="nav-link-title">Master Category</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('masters/authors*') ? 'active' : '' }}">
                    <a class="nav-link  show" href="{{ url('') }}/masters/authors">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                            </svg>
                        </span>
                        <span class="nav-link-title">Master Author</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('masters/books*') ? 'active' : '' }}">
                    <a class="nav-link  show" href="{{ url('') }}/masters/books">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-book">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <path d="M3 6l0 13" />
                                <path d="M12 6l0 13" />
                                <path d="M21 6l0 13" />
                            </svg>
                        </span>
                        <span class="nav-link-title">Master Book</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
