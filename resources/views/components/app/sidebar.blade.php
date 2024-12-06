<div class="leftside-menu">
    <style>
        .menu-arrow {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .menu-arrow.rotate {
            transform: rotate(90deg) translateX(-10px) translateY(10px);
        }
    </style>
    <!-- Brand Logo Light -->
    <a href="{{ route('dashboard') }}" class="logo logo-light">
        <span class="logo-lg">
            <div class="" style="transform: translateY(10px);">
                <img src="{{ asset('images/logo-sm.png') }}" style="width: 50px; height: 50px; transform:" alt="logo">
                <span class="text-white">Perangkat Warga App</span>
            </div>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('images/logo-sm.png') }}" style="width: 50px; height: 50px; transform: translateX(-10px) translateY(10px);" alt="logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="{{ route('dashboard') }}" class="logo logo-dark">
        <span class="logo-lg">
            <div class="" style="transform: translateY(10px);">
                <img src="{{ asset('images/logo-sm.png') }}" style="width: 50px; height: 50px; transform:" alt="logo">
                <span class="text-white">Perangkat Warga App</span>
            </div>
        </span>
        <span class="logo-sm">
            <img src="{{ asset('images/logo-sm.png') }}" style="width: 50px; height: 50px; transform: translateX(-10px) translateY(10px);" alt="logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <li class="side-nav-title"></li>
        <!--- Sidemenu -->
        <ul class="side-nav">
            {{-- <li class="side-nav-item">
                <a href="{{ route('dashboard') }}" aria-expanded="false" class="side-nav-link">
                    <i class="uil-home-alt {{ request()->routeIs('dashboard', 'home') ? 'text-white' : '' }}"></i>
                    <span class="{{ request()->routeIs('dashboard', 'home') ? 'text-white' : '' }}"> Dashboard </span>
                </a>
            </li> --}}

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTransaction" aria-expanded="false" aria-controls="sidebarTransaction" class="side-nav-link">
                    <i class="uil-layer-group {{ request()->routeIs('m-kotamadya', 'm-kotamadya.updatepage', 'm-kecamatan', 'm-kecamatan.updatepage', 'm-kelurahan', 'm-kelurahan.updatepage', 'm-rw', 'm-rw.updatepage', 'm-rt', 'm-rt.updatepage', 'm-lmk', 'm-lmk.updatepage','m-dasawisma', 'm-dasawisma.updatepage') ? 'text-white' : '' }}"></i>
                    <span class="{{ request()->routeIs('m-kotamadya', 'm-kotamadya.updatepage', 'm-kecamatan', 'm-kecamatan.updatepage', 'm-kelurahan', 'm-kelurahan.updatepage', 'm-rw', 'm-rw.updatepage', 'm-rt', 'm-rt.updatepage', 'm-lmk', 'm-lmk.updatepage','m-dasawisma', 'm-dasawisma.updatepage') ? 'text-white' : '' }}"> Transaction </span>
                    <span class="menu-arrow {{ request()->routeIs('m-kotamadya', 'm-kotamadya.updatepage', 'm-kecamatan', 'm-kecamatan.updatepage', 'm-kelurahan', 'm-kelurahan.updatepage', 'm-rw', 'm-rw.updatepage', 'm-rt', 'm-rt.updatepage', 'm-lmk', 'm-lmk.updatepage','m-dasawisma', 'm-dasawisma.updatepage') ? 'text-white' : '' }}"></span>
                </a>
                <div class="collapse {{ request()->routeIs('m-kotamadya', 'm-kotamadya.updatepage', 'm-kecamatan', 'm-kecamatan.updatepage', 'm-kelurahan', 'm-kelurahan.updatepage', 'm-rw', 'm-rw.updatepage', 'm-rt', 'm-rt.updatepage', 'm-lmk', 'm-lmk.updatepage','m-dasawisma', 'm-dasawisma.updatepage') ? 'show' : '' }}" id="sidebarTransaction">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('m-kotamadya') }}" class="{{ request()->routeIs('m-kotamadya', 'm-kotamadya.updatepage') ? 'text-white' : '' }}">Kotamadya</a>
                        </li>
                        <li>
                            <a href="{{ route('m-kecamatan') }}" class="{{ request()->routeIs('m-kecamatan', 'm-kecamatan.updatepage') ? 'text-white' : '' }}">Kecamatan</a>
                        </li>
                        <li>
                            <a href="{{ route('m-kelurahan') }}" class="{{ request()->routeIs('m-kelurahan', 'm-kelurahan.updatepage') ? 'text-white' : '' }}">Kelurahan</a>
                        </li>
                        <li>
                            <a href="{{ route('m-lmk') }}" class="{{ request()->routeIs('m-lmk', 'm-lmk.updatepage') ? 'text-white' : '' }}">LMK</a>
                        </li>
                        <li>
                            <a href="{{ route('m-rw') }}" class="{{ request()->routeIs('m-rw', 'm-rw.updatepage') ? 'text-white' : '' }}">RW</a>
                        </li>
                        <li>
                            <a href="{{ route('m-rt') }}" class="{{ request()->routeIs('m-rt', 'm-rt.updatepage') ? 'text-white' : '' }}">RT</a>
                        </li>
                        <li>
                            <a href="{{ route('m-dasawisma') }}" class="{{ request()->routeIs('m-dasawisma', 'm-dasawisma.updatepage') ? 'text-white' : '' }}">Dasawisma</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- <li class="side-nav-item">
                <a class="side-nav-link" href="{{ route('monitoring') }}" class="{{ request()->routeIs('monitoring') ? 'text-white' : '' }}">
                    <i class="uil-clipboard-alt {{ request()->routeIs('monitoring') ? 'text-white' : '' }}"></i>
                    <span class="{{ request()->routeIs('monitoring') ? 'text-white' : '' }}"> Monitoring & Report </span>
                </a>
            </li> --}}
            {{-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMonitor" aria-expanded="false" aria-controls="sidebarMonitor" class="side-nav-link">
                    <i class="uil-clipboard-alt {{ request()->routeIs('monitoring') ? 'text-white' : '' }}"></i>
                    <span class="{{ request()->routeIs('monitoring') ? 'text-white' : '' }}"> Monitoring & Report</span>
                    <span class="menu-arrow {{ request()->routeIs('monitoring') ? 'text-white' : '' }}"></span>
                </a>
                <div class="collapse {{ request()->routeIs('monitoring') ? 'text-white' : '' }}" id="sidebarMonitor">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('monitoring') }}" class="{{ request()->routeIs('monitoring') ? 'text-white' : '' }}">Monitoring & Report</a>
                        </li>
                        <li>
                            <a href="{{ route('m-kecamatan') }}" class="{{ request()->routeIs('m-kecamatan', 'm-kecamatan.updatepage') ? 'text-white' : '' }}">Monitoring Perangkat Warga</a>
                        </li>
                    </ul>
                </div>
            </li> --}}

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
@section('js-page')
<script>
</script>
@endsection