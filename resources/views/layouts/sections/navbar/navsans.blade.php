@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
@endphp

<!-- Navbar -->


<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">@include('_partials.macros', ['width' => 25, 'withbg' => 'var(--bs-primary)'])</span>
            <span
                class="app-brand-text demo menu-text fw-bold text-heading">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <div class="card p-2 border-primary shadow-sm d-inline-block "
            style="width: 50px; height: 50px; border-radius: 10px; margin:10px">
            <a class="nav-item nav-link px-0 me-xl-6 " href="javascript:void(0) ">
                <i class="bx bx-menu bx-md " style="text-align: center;
                width: 100%; "></i>
            </a>
        </div>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

</div>

@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
