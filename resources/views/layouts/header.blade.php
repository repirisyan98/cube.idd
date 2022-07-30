<!--start header -->
<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                {{ $themeClass == 'dark-theme' ? 'checked' : '' }} id="mode">
                            <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                            <i id="mode-icon" class="bx bx-{{ $themeClass == 'dark-theme' ? 'moon' : 'sun' }}"></i>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('storage/users/' . auth()->user()->foto) }}" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ auth()->user()->name }}</p>
                        {{-- <p class="designattion mb-0">Web Designer</p> --}}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i
                                class="bx bx-user"></i><span>Profile</span></a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item" href="javascript:;"><i
                                    class='bx bx-log-out-circle'></i><span>Logout</span></button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<!--end header -->
